<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tender\StoreTenderInfoRequest;
use App\Http\Requests\Tender\StoreTenderItemRequest;
use App\Models\Tender;
use App\Services\ActivityClassificationService;
use App\Services\CountryService;
use App\Services\ProposalService;
use App\Services\TenderService;
use App\Services\UnitService;
use App\Services\WorkCategoryClassificationService;
use App\Traits\CustomResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    use CustomResponse;

    public function __construct(
        protected TenderService $tenderService,
        protected ProposalService $proposalService,
        protected CountryService $countryService,
        protected UnitService $unitService,
        protected WorkCategoryClassificationService $workCategoryClassificationService,
        protected ActivityClassificationService $activityClassificationService,
    ) {}

    public function index(Request $request)
    {
        $tenders = $this->tenderService->listPublished();
        $categories = $this->workCategoryClassificationService->listForSelect();
        $classifications = $this->activityClassificationService->listForSelect();
        $filterCount = 1;
        return view('web.tenders.index', compact('tenders', 'categories', 'classifications', 'filterCount'));
    }

    public function indexAjax(Request $request)
    {
        $data = $request->all();

        $tenders = $this->tenderService->listFilterPublished($data);

        return $this->success($tenders, 'Tenders filtered successfully');
    }

    public function show(Tender $tender)
    {
        $proposalsCount = $tender->proposals()->count();
        
        return view('web.tenders.show', compact('tender', 'proposalsCount'));
    }

    public function showProposals(Tender $tender)
    {
        $data['tenderId'] = $tender->id;
        $proposalsCount = $tender->proposals()->count();
        $proposals = $this->proposalService->statusList($data);
        $statuses = $this->proposalService->listProposalStatus();
        
        return view('web.tenders.show-proposals', compact('tender', 'proposalsCount', 'proposals', 'statuses'));
    }

    public function create(Tender $tender = null)
    {
        $countries = $this->countryService->listForSelect();
        $workCategories = $this->workCategoryClassificationService->listForSelect();
        $activityClassifications = $this->activityClassificationService->listForSelect();
        return view('web.tenders.create', compact('tender', 'countries', 'workCategories', 'activityClassifications'));
    }

    public function store(Tender $tender = null, StoreTenderInfoRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth('web')->id();
        $data['contract_start_date'] = Carbon::parse($data['contract_start_date'])->format('Y-m-d');
        $data['contract_end_date'] = Carbon::parse($data['contract_end_date'])->format('Y-m-d');
        $data['closing_date'] = Carbon::parse($data['closing_date'])->format('Y-m-d');
        $data['latitude'] = round($data['latitude'], 2);
        $data['longitude'] = round($data['longitude'], 2);

        $tender = $this->tenderService->create($data, $tender);

        if (is_array($tender) && !$tender instanceof Tender) {
            return redirect()->back()->with('error', $tender['error']);
        }
        return redirect()->route('tenders.items.form', ['tender' => $tender]);
    }

    public function storeItemsForm(Tender $tender)
    {
        $units = $this->unitService->listForSelect();
        return view('web.tenders.items', compact('tender', 'units'));
    }

    // public function storeItems(Tender $tender, Request $request)
    public function storeItems(Tender $tender, StoreTenderItemRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();
        // dd($tender, $data);

        $result = $this->tenderService->itemsStore($tender, $data);
        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('tenders.review', ['tender' => $tender]);
    }

    public function reviewTender(Tender $tender)
    {
        return view('web.tenders.review', compact('tender'));
    }

    public function publishTender(Tender $tender, Request $request)
    {
        $result = $this->tenderService->publish($tender);
        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('tenders.create')->with('success', 'Tender Published Successfully');
    }
}
