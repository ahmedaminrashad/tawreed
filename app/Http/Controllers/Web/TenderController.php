<?php

namespace App\Http\Controllers\Web;

use App\Enums\ProposalStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tender\StoreTenderInfoRequest;
use App\Models\Tender;
use App\Models\TenderItem;
use App\Models\TenderItemMedia;
use App\Services\ActivityClassificationService;
use App\Services\CountryService;
use App\Services\ProposalService;
use App\Services\TenderService;
use App\Services\UnitService;
use App\Services\WorkCategoryClassificationService;
use App\Traits\CustomResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Tender\StoreTenderItemRequest;


class TenderController extends Controller
{
    use CustomResponse;

    public function __construct(
        protected TenderService                     $tenderService,
        protected ProposalService                   $proposalService,
        protected CountryService                    $countryService,
        protected UnitService                       $unitService,
        protected WorkCategoryClassificationService $workCategoryClassificationService,
        protected ActivityClassificationService     $activityClassificationService,
    )
    {
    }

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


    public function storeItemFile(Request $request)
    {
        $file = $request->file('file');
        $tender_id = $request->get('tender_id');
        $destinationPath = "files";

        $upload_success = Storage::disk('public')->put($destinationPath, $file);
        $media = TenderItemMedia::query()->create([
            'tender_id' => $tender_id,
            'index_item' => $request->get('item_index'),
            'file' => $upload_success,
            'tender_item_id' => $request->tender_item_id,
        ]);
        return $media;
    }

    public function deleteItemMedia(Request $request)
    {
        $media = TenderItemMedia::query()
            ->where('tender_id', $request->tender_id)
            ->find($request->id);

        if ($media) {
            return  deleteFileItem($media);
        }

        return 'error';

    }



    public function showProposals(Tender $tender)
    {
        if (auth()->id() === $tender->user_id) {
            // Tender owner: get all proposals for this tender
            $data['all'] = true;
        } else {
            $data['user_id'] = auth()->id();
        }
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
        $tender->load('items.media');
        $units = $this->unitService->listForSelect();
        $files = TenderItemMedia::query()->where('tender_id', $tender->id)
            ->wherenull('tender_item_id')
            ->get();
        foreach ($files as $file) {
            deleteFileItem($file);
        }
        return view('web.tenders.items', compact('tender', 'units'));
    }

    // public function storeItems(Tender $tender, Request $request)
    public function storeItems(Tender $tender, StoreTenderItemRequest $request)
    {
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

    public function removeItem(Request $request): string
    {

        $item = TenderItem::query()
            ->with('media')
            ->where('tender_id',$request->tender_id)->find($request->id);

        foreach (@$item->media as $media) {
            deleteFileItem($media);
        }

        $item->delete();
        return 'success';


    }

    public function publishTender(Tender $tender, Request $request)
    {
        $result = $this->tenderService->publish($tender);

        if (is_array($result)) {
            return redirect()->back()->with('error', $result['error']);
        }

        $proposalStatus = ProposalStatus::UNDER_REVIEW->value;

        $response = $this->tenderService->updateTenderProposalsStatus($tender, $proposalStatus);

        if (is_array($response)) {
            return redirect()->back()->with('error', $response['error']);
        }

        return redirect()->route('tenders.show', ['tender' => $tender])->with('success', 'Tender Published Successfully');
    }
}
