<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkCategoryClassification\StoreWorkCategoryClassificationRequest;
use App\Http\Requests\WorkCategoryClassification\UpdateWorkCategoryClassificationRequest;
use App\Models\WorkCategoryClassification;
use App\Services\WorkCategoryClassificationService;
use Illuminate\Http\Request;
use Throwable;

class WorkCategoryClassificationController extends Controller
{
    public function __construct(
        private readonly WorkCategoryClassificationService $workCategoryClassificationService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classifications = $this->workCategoryClassificationService->list();

        if ($request->ajax()) {
            $data['columns']    = $request->columns;
            $data['order']      = $request->order[0]['column'];
            $data['orderBy']    = $data['columns'][$data['order']]["name"];
            $data['orderDir']   = $request->order[0]['dir'];
            $data['search']     = $request->search;

            return $this->workCategoryClassificationService->listAjax($data);
        }

        return view('admin.classifications.index', compact('classifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create Work Category Classification';

        $pageAction = 'Create';

        $formTitle = 'Create Work Category Classification';

        return view('admin.classifications.create', compact('pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkCategoryClassificationRequest $request)
    {
        $data = $request->validated();

        $workCategoryClassification = $this->workCategoryClassificationService->create($data);

        return redirect()->route('admin.classifications.show', ['classification' => $workCategoryClassification])->with('success', 'Work Category Classification created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkCategoryClassification $classification)
    {
        return view('admin.classifications.show', compact('classification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkCategoryClassification $classification)
    {
        $pageTitle = 'Edit WorkCategoryClassification';

        $pageAction = 'Edit';

        $formTitle = 'Edit WorkCategoryClassification';

        return view('admin.classifications.edit', compact('classification', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkCategoryClassificationRequest $request, WorkCategoryClassification $classification)
    {
        $data = $request->validated();

        $workCategoryClassification = $this->workCategoryClassificationService->update($classification, $data);

        return redirect()->route('admin.classifications.show', ['classification' => $classification])->with('success', 'Work Category Classification updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkCategoryClassification $classification)
    {
        return redirect()->route('admin.classifications.index');
        
        try {
            $result = $this->workCategoryClassificationService->delete($classification);

            if (!$result) {
                return redirect()->route('admin.classifications.index')->with('error', 'Work Category Classification can\'t be deleted');
            }

            return redirect()->route('admin.classifications.index')->with('success', 'Work Category Classification deleted successfully');
        } catch (Throwable $throwable) {
            return redirect()->route('admin.classifications.index')->with(['error' => $throwable->getMessage()]);
        }
    }
}
