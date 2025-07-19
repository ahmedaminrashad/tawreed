<?php

namespace App\Http\Controllers\Web;

use App\Enums\ProposalStatus;
use App\Enums\TenderStatus;
use App\Models\Proposal;
use App\Http\Controllers\Controller;
use App\Http\Requests\Proposal\RejectProposalRequest;
use App\Http\Requests\Proposal\RequestSampleProposalRequest;
use App\Http\Requests\Proposal\StoreTenderProposalInfoRequest;
use App\Http\Requests\Proposal\StoreTenderProposalItemRequest;
use App\Http\Requests\Proposal\UpdateTenderProposalStatusRequest;
use App\Models\Tender;
use App\Services\ProposalService;
use App\Services\TenderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function __construct(
        protected ProposalService $proposalService,
        protected TenderService $tenderService,
    ) {}

    public function info(Tender $tender, Proposal $proposal)
    {
        return view('web.proposals.info', compact('tender', 'proposal'));
    }

    // public function storeInfo(Tender $tender, Proposal $proposal, Request $request)
    public function storeInfo(Tender $tender, Proposal $proposal, StoreTenderProposalInfoRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();
        // dd($data);

        $data['proposal_end_date'] = Carbon::parse($data['proposal_end_date'])->format('Y-m-d');

        $result = $this->proposalService->update($proposal, $data);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('tenders.proposals.review', ['tender' => $tender, 'proposal' => $result]);
    }

    public function items(Tender $tender, Proposal $proposal = null)
    {
        if(auth()->id() == $tender->user_id || in_array(auth()->id(), $tender->proposals()->pluck('user_id')->toArray())) {
            return redirect()->route('profile.tenders')->with('error', 'You can not submit proposal on your own tender');
        }

        return view('web.proposals.items', compact('tender', 'proposal'));
    }

    public function storeItems(Tender $tender, Proposal $proposal = null, StoreTenderProposalItemRequest $request)
    {
        $data = $request->validated();

        $result = $this->proposalService->itemsStore($tender, $proposal, $data);
        
        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('tenders.proposals.info', ['tender' => $tender, 'proposal' => $result]);
    }

    public function reviewProposal(Tender $tender, Proposal $proposal)
    {
        return view('web.proposals.review', compact('tender', 'proposal'));
    }

    public function publishProposal(Tender $tender, Proposal $proposal, Request $request)
    {
        $result = $this->proposalService->publish($proposal);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('tenders.show', ['tender' => $tender])->with('success', 'Proposal submitted successfully');
    }

    public function show(Proposal $proposal)
    {
        // can access by tender owner or proposal owner  only
        $userId = auth()->id();
        if ($proposal->user_id !== $userId && $proposal->tender->user_id !== $userId) {
            abort(403, __('web.unauthorized_access_to_proposal'));
        }

        return view('web.proposals.show', compact('proposal'));
    }

    public function updateStatus(Proposal $proposal, UpdateTenderProposalStatusRequest $request)
    {
        $data = $request->validated();

        $result = $this->proposalService->update($proposal, $data);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }
        
        return redirect()->route('proposals.show', ['proposal' => $proposal])->with('success', 'Proposal status updated successfully');
    }

    public function initialAccept(Proposal $proposal)
    {
        $status = ProposalStatus::INITIAL_ACCEPTANCE->value;

        $result = $this->proposalService->updateStatus($proposal, $status);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }
        
        return redirect()->route('proposals.show', ['proposal' => $proposal])->with('success', 'Proposal Initial Accept successfully');
    }

    public function requestSample(Proposal $proposal, RequestSampleProposalRequest $request)
    {
        $data = $request->validated();

        $result = $this->proposalService->requestSample($proposal, $data);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }
        
        return redirect()->route('proposals.show', ['proposal' => $proposal])->with('success', 'Proposal Request Sample successfully');
    }

    public function sampleSent(Proposal $proposal)
    {
        $status = ProposalStatus::INITIAL_ACCEPTANCE_SAMPLE_SENT->value;

        $result = $this->proposalService->updateStatus($proposal, $status);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }
        
        return redirect()->route('proposals.show', ['proposal' => $proposal])->with('success', 'Proposal Sample Sent successfully');
    }

    public function withdraw(Proposal $proposal)
    {
        $status = ProposalStatus::WITHDRAWN->value;

        $result = $this->proposalService->updateStatus($proposal, $status);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }
        
        return redirect()->route('proposals.show', ['proposal' => $proposal])->with('success', 'Proposal Withdrawn successfully');
    }

    public function reject(Proposal $proposal, RejectProposalRequest $request)
    {
        $data['rejected_by'] = auth()->id();
        $data['reject_reason'] = $request->reject_reason;
        $data['custom_reject_reason'] = $request->custom_reject_reason ?? null;
        $data['status'] = ProposalStatus::REJECTED->value;

        $result = $this->proposalService->update($proposal, $data);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }
        
        return redirect()->route('proposals.show', ['proposal' => $proposal])->with('success', 'Proposal Rejected successfully');
    }

    public function finalAccept(Proposal $proposal)
    {
        $status = ProposalStatus::FINAL_ACCEPTANCE->value;

        $result = $this->proposalService->updateStatus($proposal, $status);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }

        $tenderStatus = TenderStatus::AWARDED->value;

        $response = $this->tenderService->updateStatus($proposal->tender, $tenderStatus);

        if (is_array($response)) {
            return redirect()->back()->with('error', $response['error']);
        }
        
        return redirect()->route('proposals.show', ['proposal' => $proposal])->with('success', 'Proposal Final Acceptance successfully');
    }
}
