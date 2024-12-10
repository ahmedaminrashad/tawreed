<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RejectionReason\StoreRejectionReasonRequest;
use App\Http\Requests\RejectionReason\UpdateRejectionReasonRequest;
use App\Models\RejectionReason;
use App\Services\RejectionReasonService;
use Illuminate\Http\Request;
use Throwable;

class RejectionReasonController extends Controller
{
    public function __construct(
        private readonly RejectionReasonService $rejectionReasonService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rejections = $this->rejectionReasonService->list();

        if ($request->ajax()) {
            $data['columns']    = $request->columns;
            $data['order']      = $request->order[0]['column'];
            $data['orderBy']    = $data['columns'][$data['order']]["name"];
            $data['orderDir']   = $request->order[0]['dir'];
            $data['search']     = $request->search;

            return $this->rejectionReasonService->listAjax($data);
        }

        return view('admin.rejections.index', compact('rejections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create Rejection Reason';

        $pageAction = 'Create';

        $formTitle = 'Create Rejection Reason';

        return view('admin.rejections.create', compact('pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRejectionReasonRequest $request)
    {
        $data = $request->validated();

        $rejection = $this->rejectionReasonService->create($data);

        return redirect()->route('admin.rejections.show', ['rejection' => $rejection])->with('success', 'Rejection Reason created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(RejectionReason $rejection)
    {
        return view('admin.rejections.show', compact('rejection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RejectionReason $rejection)
    {
        $pageTitle = 'Edit Rejection Reason';

        $pageAction = 'Edit';

        $formTitle = 'Edit Rejection Reason';

        return view('admin.rejections.edit', compact('rejection', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRejectionReasonRequest $request, RejectionReason $rejection)
    {
        $data = $request->validated();

        $rejection = $this->rejectionReasonService->update($rejection, $data);

        return redirect()->route('admin.rejections.show', ['rejection' => $rejection])->with('success', 'Rejection Reason updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RejectionReason $rejection)
    {
        return redirect()->route('admin.rejections.index');
        
        try {
            $result = $this->rejectionReasonService->delete($rejection);

            if (!$result) {
                return redirect()->route('admin.rejections.index')->with('error', 'Rejection Reason can\'t be deleted');
            }

            return redirect()->route('admin.rejections.index')->with('success', 'Rejection Reason deleted successfully');
        } catch (Throwable $throwable) {
            return redirect()->route('admin.rejections.index')->with(['error' => $throwable->getMessage()]);
        }
    }
}
