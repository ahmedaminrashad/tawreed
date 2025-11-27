<?php

namespace App\Services;

use App\Enums\ProposalStatus;
use App\Mail\NewProposalNotificationMail;
use App\Mail\ProposalWithdrawnNotificationMail;
use App\Mail\ProposalUpdatedNotificationMail;
use App\Mail\ProposalStatusUpdatedNotificationMail;
use App\Models\Notification;
use App\Models\Proposal;
use App\Models\ProposalItem;
use App\Models\Tender;
use App\Services\Web\EmailService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

readonly class ProposalService
{
    public function __construct(
        protected TenderService $tenderService,
        protected EmailService $emailService,
        protected \App\Services\SettingService $settingService,
    ) {}

    // list all Proposals function
    public function list($data)
    {
        $proposals = $this->getQuery($data);

        return $proposals->orderBy('created_at', 'DESC')->get();
    }

    // Get Proposal Query function
    private function getQuery($data)
    {
        $proposals = Proposal::select('*');

        if (isset($data['userId'])) {
            $proposals = $proposals->where('user_id', $data['userId']);
        }

        if (isset($data['tenderId'])) {
            $proposals = $proposals->where('tender_id', $data['tenderId']);
        }

        return $proposals;
    }

    // list all Profile Proposals function
    public function statusList($data)
    {
        $statuses = ProposalStatus::values();

        foreach ($statuses as $status) {

//            if ($status == ProposalStatus::CREATED->value || $status == ProposalStatus::DRAFT->value) {
//                continue;
//            }

            $qry = $this->getQuery($data);

            $final = str_replace(' ', '_', $status);
            $final = str_replace('(', '', $final);
            $final = str_replace(')', '', $final);

            $proposals[$final] = $qry->where('status', $status)->orderBy('created_at', 'DESC')->get();
        }

        return $proposals;
    }

    // list all Proposals Statuses function
    public function listProposalStatus()
    {
        $statuses = ProposalStatus::cases();
        $data = [];

        foreach ($statuses as $statusEnum) {
//            if ($statusEnum == ProposalStatus::CREATED || $statusEnum == ProposalStatus::DRAFT) {
//                continue;
//            }

            $status = $statusEnum->value;
            $final = str_replace(' ', '_', $status);
            $final = str_replace('(', '', $final);
            $final = str_replace(')', '', $final);

            // Use label instead of raw value
            $data[$final] = $statusEnum->getLabel();
        }

        return $data;
    }

    // list all Published Proposals function
    public function listPublished() {}

    // list all Published Proposals With filters function
    public function listFilterPublished($filters) {}

    // list all Proposals function AJAX
    public function listAjax($ajaxData) {}

    // get Proposal by ID function
    public function getById($id)
    {
        $proposal = Proposal::find($id);

        return $proposal;
    }

    // Store new Proposal
    public function create($data, Tender $tender, Proposal $proposal = null)
    {
        try {
            DB::beginTransaction();

            if ($proposal) {
                $proposal->update($data);
            } else {
                $proposal = Proposal::create([
                    'tender_id' => $tender->id,
                    'user_id' => auth()->id(),
                ], [
                    'total' => null,
                    'status' => ProposalStatus::DRAFT->value,
                ]);
            }

            DB::commit();

            return $proposal;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Store Proposal Items
    public function itemsStore(Tender $tender, Proposal $proposal = null, $data)
    {
        try {
            // Prevent update if proposal has final acceptance status
            if ($proposal && $proposal->status === ProposalStatus::FINAL_ACCEPTANCE->value) {
                return ['error' => __('web.proposal_cannot_be_updated_final_acceptance')];
            }

            // Check if tender closing date has passed
            if ($tender->closing_date && $tender->closing_date->lt(Carbon::today())) {
                return ['error' => __('web.tender_closing_date_passed_no_proposal_updates')];
            }

            if ($proposal && $proposal->id) {
                $proposal->items()->delete();
            } else {
                $result = $this->create([], $tender);
                if (is_array($result)) {
                    return ['error' => $result['error']];
                }
                $proposal = $result;
                $proposal->items()->delete();
            }

            // dd($proposal);

            DB::beginTransaction();

            $proposalTotal = 0;

            foreach ($data['items'] as $itemId => $item) {
                $tenderItem = $this->tenderService->getItemById($itemId);

                $itemTotal = $tenderItem->quantity * $item['unit_price'];

                $proposalTotal += $itemTotal;

                ProposalItem::create([
                    'proposal_id' => $proposal->id,
                    'item_id' => $itemId,
                    'name' => $tenderItem->name,
                    'quantity' => $tenderItem->quantity,
                    'unit_id' => $tenderItem->unit_id,
                    'item_specs' => $tenderItem->specs,
                    'price' => $item['unit_price'],
                    'total' => $itemTotal,
                    'seller_item_specs' => $item['seller_item_specs'],
                ]);
            }

            $proposal->update(['total' => $proposalTotal]);

            DB::commit();

            $result = $this->updateStatus($proposal, ProposalStatus::CREATED->value);

            if (is_array($result)) {
                return ['error' => 'Error in update Proposal Status'];
            }

            return $proposal;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Publish Proposal
    public function publish(Proposal $proposal)
    {
        try {
            // Prevent publish if proposal has final acceptance status
            if ($proposal->status === ProposalStatus::FINAL_ACCEPTANCE->value) {
                return ['error' => __('web.proposal_cannot_be_updated_final_acceptance')];
            }

            // Check if tender closing date has passed
            $tender = $proposal->tender;
            if ($tender->closing_date && $tender->closing_date->lt(Carbon::today())) {
                return ['error' => __('web.tender_closing_date_passed_no_proposal_updates')];
            }

            $result = $this->updateStatus($proposal, ProposalStatus::UNDER_REVIEW->value);

            if (is_array($result)) {
                return ['error' => 'Error in publish Proposal'];
            }

            // Send notification and email to tender owner
            $this->sendProposalNotification($proposal);

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Send Proposal Notification
    private function sendProposalNotification(Proposal $proposal)
    {
        try {
            $tender = $proposal->tender;
            $tenderOwner = $tender->user;
            $proposalOwner = $proposal->user;

            // Prepare notification data
            $messageAr = __('web.new_proposal_received_ar', [
                'tender_subject' => $tender->subject,
                'proposal_owner' => $proposalOwner->displayed_name
            ]);
            $messageEn = __('web.new_proposal_received_en', [
                'tender_subject' => $tender->subject,
                'proposal_owner' => $proposalOwner->displayed_name
            ]);

            // Create notification record
            Notification::create([
                'user_id' => $tenderOwner->id,
                'message_ar' => $messageAr,
                'message_en' => $messageEn,
                'is_read' => false,
            ]);

            // Prepare email data
            $emailData = [
                'date' => Carbon::today()->format('d M, Y'),
                'tender_owner_name' => $tenderOwner->displayed_name,
                'tender_subject' => $tender->subject,
                'proposal_owner_name' => $proposalOwner->displayed_name,
                'proposal_url' => route('proposals.show', ['proposal' => $proposal->id]),
                'tender_owner_email' => $tenderOwner->email,
                'administratorEmail' => $this->settingService->getByKey('email')->value,
                'locale' => app()->getLocale(), // Pass current locale for email
            ];

            // Send email notification
            Mail::to($tenderOwner->email)->send(new NewProposalNotificationMail($proposal, $emailData));

        } catch (\Exception $e) {
            // Log error but don't fail the proposal publish
            \Log::error('Failed to send proposal notification: ' . $e->getMessage());
        }
    }

    // Send Proposal Updated Notification
    private function sendProposalUpdatedNotification(Proposal $proposal)
    {
        try {
            $tender = $proposal->tender;
            $tenderOwner = $tender->user;
            $proposalOwner = $proposal->user;

            // Prepare notification data
            $messageAr = __('web.proposal_updated_notification_ar', [
                'tender_subject' => $tender->subject,
                'tender_owner' => $tenderOwner->displayed_name
            ]);
            $messageEn = __('web.proposal_updated_notification_en', [
                'tender_subject' => $tender->subject,
                'tender_owner' => $tenderOwner->displayed_name
            ]);

            // Create notification record
            Notification::create([
                'user_id' => $proposalOwner->id,
                'message_ar' => $messageAr,
                'message_en' => $messageEn,
                'is_read' => false,
            ]);

            // Prepare email data
            $emailData = [
                'date' => Carbon::today()->format('d M, Y'),
                'tender_owner_name' => $tenderOwner->displayed_name,
                'tender_subject' => $tender->subject,
                'proposal_owner_name' => $proposalOwner->displayed_name,
                'proposal_url' => route('proposals.show', ['proposal' => $proposal->id]),
                'proposal_owner_email' => $proposalOwner->email,
                'administratorEmail' => $this->settingService->getByKey('email')->value,
                'locale' => app()->getLocale(), // Pass current locale for email
            ];

            // Send email notification
            Mail::to($proposalOwner->email)->send(new ProposalUpdatedNotificationMail($proposal, $emailData));

        } catch (\Exception $e) {
            // Log error but don't fail the proposal update
            \Log::error('Failed to send proposal updated notification: ' . $e->getMessage());
        }
    }

    // Send Proposal Status Updated Notification
    private function sendProposalStatusUpdatedNotification(Proposal $proposal, $newStatus)
    {
        try {
            $tender = $proposal->tender;
            $tenderOwner = $tender->user;
            $proposalOwner = $proposal->user;

            // Get status label
            $statusEnum = ProposalStatus::from($newStatus);
            $statusLabel = $statusEnum->getLabel();

            // Prepare notification data
            $messageAr = __('web.proposal_status_updated_notification_ar', [
                'tender_subject' => $tender->subject,
                'status' => $statusLabel
            ]);
            $messageEn = __('web.proposal_status_updated_notification_en', [
                'tender_subject' => $tender->subject,
                'status' => $statusLabel
            ]);

            // Create notification record
            Notification::create([
                'user_id' => $proposalOwner->id,
                'message_ar' => $messageAr,
                'message_en' => $messageEn,
                'is_read' => false,
            ]);

            // Prepare email data
            $emailData = [
                'date' => Carbon::today()->format('d M, Y'),
                'tender_owner_name' => $tenderOwner->displayed_name,
                'tender_subject' => $tender->subject,
                'proposal_owner_name' => $proposalOwner->displayed_name,
                'proposal_url' => route('proposals.show', ['proposal' => $proposal->id]),
                'proposal_owner_email' => $proposalOwner->email,
                'administratorEmail' => $this->settingService->getByKey('email')->value,
                'status_label' => $statusLabel,
                'locale' => app()->getLocale(), // Pass current locale for email
            ];

            // Add reject reason if status is rejected
            if ($newStatus === ProposalStatus::REJECTED->value) {
                // Reload proposal to get updated rejection reason
                $proposal->refresh();
                if ($proposal->rejection_reason) {
                    $rejectionReason = $proposal->rejection;
                    if ($rejectionReason) {
                        $emailData['reject_reason'] = $rejectionReason->translate(app()->getLocale())->name ?? $rejectionReason->name;
                    }
                }
                if (isset($proposal->custom_reject_reason) && $proposal->custom_reject_reason) {
                    $emailData['reject_reason'] = $proposal->custom_reject_reason;
                }
            }

            // Send email notification
            Mail::to($proposalOwner->email)->send(new ProposalStatusUpdatedNotificationMail($proposal, $emailData));

        } catch (\Exception $e) {
            // Log error but don't fail the status update
            \Log::error('Failed to send proposal status updated notification: ' . $e->getMessage());
        }
    }

    // Send Proposal Withdrawn Notification
    private function sendProposalWithdrawnNotification(Proposal $proposal)
    {
        try {
            $tender = $proposal->tender;
            $tenderOwner = $tender->user;
            $proposalOwner = $proposal->user;

            // Prepare notification data
            $messageAr = __('web.proposal_withdrawn_ar', [
                'tender_subject' => $tender->subject,
                'proposal_owner' => $proposalOwner->displayed_name
            ]);
            $messageEn = __('web.proposal_withdrawn_en', [
                'tender_subject' => $tender->subject,
                'proposal_owner' => $proposalOwner->displayed_name
            ]);

            // Create notification record
            Notification::create([
                'user_id' => $tenderOwner->id,
                'message_ar' => $messageAr,
                'message_en' => $messageEn,
                'is_read' => false,
            ]);

            // Prepare email data
            $emailData = [
                'date' => Carbon::today()->format('d M, Y'),
                'tender_owner_name' => $tenderOwner->displayed_name,
                'tender_subject' => $tender->subject,
                'proposal_owner_name' => $proposalOwner->displayed_name,
                'proposal_url' => route('proposals.show', ['proposal' => $proposal->id]),
                'tender_owner_email' => $tenderOwner->email,
                'administratorEmail' => $this->settingService->getByKey('email')->value,
                'locale' => app()->getLocale(), // Pass current locale for email
            ];

            // Send email notification
            Mail::to($tenderOwner->email)->send(new ProposalWithdrawnNotificationMail($proposal, $emailData));

        } catch (\Exception $e) {
            // Log error but don't fail the proposal withdrawal
            \Log::error('Failed to send proposal withdrawn notification: ' . $e->getMessage());
        }
    }

    // Update Proposal
    public function update(Proposal $proposal, $data)
    {
        try {
            // Prevent update if proposal has final acceptance status
            if ($proposal->status === ProposalStatus::FINAL_ACCEPTANCE->value) {
                return ['error' => __('web.proposal_cannot_be_updated_final_acceptance')];
            }

            // Check if tender closing date has passed
            $tender = $proposal->tender;
            if ($tender->closing_date && $tender->closing_date->lt(Carbon::today())) {
                return ['error' => __('web.tender_closing_date_passed_no_proposal_updates')];
            }

            DB::beginTransaction();

            // Check if tender owner is updating (not proposal owner)
            $currentUserId = auth()->id();
            $isTenderOwnerUpdating = $proposal->tender->user_id === $currentUserId && $proposal->user_id !== $currentUserId;
            
            // Check if status is being updated
            $oldStatus = $proposal->status;
            $newStatus = $data['status'] ?? null;

            $proposal->update($data);

            DB::commit();

            // Send notification to proposal creator if tender owner updated it
            if ($isTenderOwnerUpdating) {
                // If status was changed, send status update notification
                if ($newStatus && $oldStatus !== $newStatus && !in_array($newStatus, [ProposalStatus::DRAFT->value, ProposalStatus::CREATED->value])) {
                    $this->sendProposalStatusUpdatedNotification($proposal, $newStatus);
                } else {
                    // Otherwise send general update notification
                    $this->sendProposalUpdatedNotification($proposal);
                }
            }

            return $proposal;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Update Proposal Status
    public function updateStatus(Proposal $proposal, $status)
    {
        try {
            // Prevent status update if proposal has final acceptance status
            if ($proposal->status === ProposalStatus::FINAL_ACCEPTANCE->value) {
                return ['error' => __('web.proposal_cannot_be_updated_final_acceptance')];
            }

            // Check if tender closing date has passed
            $tender = $proposal->tender;
            if ($tender->closing_date && $tender->closing_date->lt(Carbon::today())) {
                return ['error' => __('web.tender_closing_date_passed_no_proposal_updates')];
            }

            DB::beginTransaction();

            // Check if tender owner is updating status (not proposal owner)
            $currentUserId = auth()->id();
            $isTenderOwnerUpdating = $proposal->tender->user_id === $currentUserId && $proposal->user_id !== $currentUserId;
            $oldStatus = $proposal->status;

            $proposal->update([
                'status' => $status
            ]);

            DB::commit();

            // Send notification if proposal is withdrawn (by proposal owner)
            if ($status === ProposalStatus::WITHDRAWN->value) {
                $this->sendProposalWithdrawnNotification($proposal);
            }
            // Send notification to proposal creator if tender owner updated status
            elseif ($isTenderOwnerUpdating && $oldStatus !== $status) {
                // Only send for meaningful status changes (not draft/created)
                if (!in_array($status, [ProposalStatus::DRAFT->value, ProposalStatus::CREATED->value])) {
                    $this->sendProposalStatusUpdatedNotification($proposal, $status);
                }
            }

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Request Sample Proposal Status
    public function requestSample(Proposal $proposal, $data)
    {
        try {
            // Prevent sample request if proposal has final acceptance status
            if ($proposal->status === ProposalStatus::FINAL_ACCEPTANCE->value) {
                return ['error' => __('web.proposal_cannot_be_updated_final_acceptance')];
            }

            // Check if tender closing date has passed
            $tender = $proposal->tender;
            if ($tender->closing_date && $tender->closing_date->lt(Carbon::today())) {
                return ['error' => __('web.tender_closing_date_passed_no_proposal_updates')];
            }

            DB::beginTransaction();

            // Check if tender owner is requesting sample (not proposal owner)
            $currentUserId = auth()->id();
            $isTenderOwnerUpdating = $proposal->tender->user_id === $currentUserId && $proposal->user_id !== $currentUserId;
            $oldStatus = $proposal->status;

            $proposal->update([
                'sample_request' => $data['sample_request'],
                'status' => ProposalStatus::INITIAL_ACCEPTANCE_SAMPLE_REQUESTED->value,
            ]);

            DB::commit();

            // Send notification to proposal creator if tender owner requested sample
            if ($isTenderOwnerUpdating && $oldStatus !== ProposalStatus::INITIAL_ACCEPTANCE_SAMPLE_REQUESTED->value) {
                $this->sendProposalStatusUpdatedNotification($proposal, ProposalStatus::INITIAL_ACCEPTANCE_SAMPLE_REQUESTED->value);
            }

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Delete Proposal
    public function delete(Proposal $proposal)
    {
        return $proposal->delete();
    }
}
