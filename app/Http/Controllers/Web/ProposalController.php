<?php

namespace App\Http\Controllers\Web;

use App\Models\Proposal;
use App\Http\Controllers\Controller;
use App\Http\Requests\Proposal\StoreTenderProposalInfoRequest;
use App\Http\Requests\Proposal\StoreTenderProposalItemRequest;
use App\Models\Tender;
use App\Services\ProposalService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function __construct(
        protected ProposalService $proposalService,
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

    public function publishTender(Tender $tender, Proposal $proposal, Request $request)
    {
        $result = $this->proposalService->publish($proposal);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('tenders.show', ['tender' => $tender])->with('success', 'Proposal submitted successfully');
    }

    public function show(Proposal $proposal)
    {
        return view('web.proposals.show', compact('proposal'));
    }
}
