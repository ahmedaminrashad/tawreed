<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tender\StoreTenderInfoRequest;
use App\Http\Requests\Tender\StoreTenderItemRequest;
use App\Models\Tender;
use App\Services\ActivityClassificationService;
use App\Services\CountryService;
use App\Services\TenderService;
use App\Services\UnitService;
use App\Services\WorkCategoryClassificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function __construct(
        protected TenderService $tenderService,
        protected CountryService $countryService,
        protected UnitService $unitService,
        protected WorkCategoryClassificationService $workCategoryClassificationService,
        protected ActivityClassificationService $activityClassificationService,
    ) {}

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

        $data['user_id'] = auth('api')->id();
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

    // public function storeItems(Request $request)
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
        // dd($tender->items);
        return view('web.tenders.review', compact('tender'));
    }
}
