<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityClassification\StoreActivityClassificationRequest;
use App\Http\Requests\ActivityClassification\UpdateActivityClassificationRequest;
use App\Models\ActivityClassification;
use App\Services\ActivityClassificationService;
use Illuminate\Http\Request;
use Throwable;

class ActivityClassificationController extends Controller
{
    public function __construct(
        private readonly ActivityClassificationService $activityClassificationService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activityClassifications = $this->activityClassificationService->list();

        if ($request->ajax()) {
            $data['columns']    = $request->columns;
            $data['order']      = $request->order[0]['column'];
            $data['orderBy']    = $data['columns'][$data['order']]["name"];
            $data['orderDir']   = $request->order[0]['dir'];
            $data['search']     = $request->search;

            return $this->activityClassificationService->listAjax($data);
        }

        return view('admin.activity-classifications.index', compact('activityClassifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create Activity Classification';

        $pageAction = 'Create';

        $formTitle = 'Create Activity Classification';

        return view('admin.activity-classifications.create', compact('pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityClassificationRequest $request)
    {
        $data = $request->validated();

        $workCategoryClassification = $this->activityClassificationService->create($data);

        return redirect()->route('admin.activity-classifications.show', ['activity_classification' => $workCategoryClassification])->with('success', 'Activity Classification created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityClassification $activity_classification)
    {
        return view('admin.activity-classifications.show', compact('activity_classification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityClassification $activity_classification)
    {
        $pageTitle = 'Edit Activity Classification';

        $pageAction = 'Edit';

        $formTitle = 'Edit Activity Classification';

        return view('admin.activity-classifications.edit', compact('activity_classification', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityClassificationRequest $request, ActivityClassification $activity_classification)
    {
        $data = $request->validated();

        $activity_classification = $this->activityClassificationService->update($activity_classification, $data);

        return redirect()->route('admin.activity-classifications.show', ['activity_classification' => $activity_classification])->with('success', 'Activity Classification updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityClassification $activity_classification)
    {
        return redirect()->route('admin.activity-classifications.index');
        
        try {
            $result = $this->activityClassificationService->delete($activity_classification);

            if (!$result) {
                return redirect()->route('admin.activity-classifications.index')->with('error', 'Activity Classification can\'t be deleted');
            }

            return redirect()->route('admin.activity-classifications.index')->with('success', 'Activity Classification deleted successfully');
        } catch (Throwable $throwable) {
            return redirect()->route('admin.activity-classifications.index')->with(['error' => $throwable->getMessage()]);
        }
    }
}
