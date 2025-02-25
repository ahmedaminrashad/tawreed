<?php

namespace App\Services;

use App\Enums\ProposalStatus;
use App\Enums\TenderStatus;
use App\Models\Proposal;
use App\Models\ProposalItem;
use App\Models\Tender;
use App\Models\TenderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

readonly class ProposalService
{
    public function __construct(
        protected TenderService $tenderService,
    ) {}

    // list all Proposals function
    public function list($data) {}

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
                $proposal = Proposal::updateOrCreate([
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
            if ($proposal->id) {
                $proposal->items()->delete();
            } else {
                $result = $this->create([], $tender);
                if (is_array($result)) {
                    return ['error' => $result['error']];
                }
                $proposal = $result;
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

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Publish Proposal
    public function publish(Proposal $proposal)
    {
        try {
            $result = $this->updateStatus($proposal, ProposalStatus::UNDER_REVIEW->value);

            if (is_array($result)) {
                return ['error' => 'Error in publish Proposal'];
            }

            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    // Update Proposal
    public function update(Proposal $proposal, $data)
    {
        try {
            DB::beginTransaction();

            $proposal->update($data);

            DB::commit();

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
            DB::beginTransaction();

            $proposal->update([
                'status' => $status
            ]);

            DB::commit();

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
