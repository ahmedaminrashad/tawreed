<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CancellationReason\StoreCancellationReasonRequest;
use App\Http\Requests\CancellationReason\UpdateCancellationReasonRequest;
use App\Models\CancellationReason;
use App\Services\CancellationReasonService;
use Illuminate\Http\Request;
use Throwable;

class CancellationReasonController extends Controller
{
    public function __construct(
        private readonly CancellationReasonService $cancellationReasonService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cancellations = $this->cancellationReasonService->list();

        if ($request->ajax()) {
            $data['columns']    = $request->columns;
            $data['order']      = $request->order[0]['column'];
            $data['orderBy']    = $data['columns'][$data['order']]["name"];
            $data['orderDir']   = $request->order[0]['dir'];
            $data['search']     = $request->search;

            return $this->cancellationReasonService->listAjax($data);
        }

        return view('admin.cancellations.index', compact('cancellations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create Cancellation Reason';

        $pageAction = 'Create';

        $formTitle = 'Create Cancellation Reason';

        return view('admin.cancellations.create', compact('pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCancellationReasonRequest $request)
    {
        $data = $request->validated();

        $cancellation = $this->cancellationReasonService->create($data);

        return redirect()->route('admin.cancellations.show', ['cancellation' => $cancellation])->with('success', 'Cancellation Reason created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(CancellationReason $cancellation)
    {
        return view('admin.cancellations.show', compact('cancellation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CancellationReason $cancellation)
    {
        $pageTitle = 'Edit Cancellation Reason';

        $pageAction = 'Edit';

        $formTitle = 'Edit Cancellation Reason';

        return view('admin.cancellations.edit', compact('cancellation', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCancellationReasonRequest $request, CancellationReason $cancellation)
    {
        $data = $request->validated();

        $cancellation = $this->cancellationReasonService->update($cancellation, $data);

        return redirect()->route('admin.cancellations.show', ['cancellation' => $cancellation])->with('success', 'Cancellation Reason updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CancellationReason $cancellation)
    {
        return redirect()->route('admin.cancellations.index');
        
        try {
            $result = $this->cancellationReasonService->delete($cancellation);

            if (!$result) {
                return redirect()->route('admin.cancellations.index')->with('error', 'Cancellation Reason can\'t be deleted');
            }

            return redirect()->route('admin.cancellations.index')->with('success', 'Cancellation Reason deleted successfully');
        } catch (Throwable $throwable) {
            return redirect()->route('admin.cancellations.index')->with(['error' => $throwable->getMessage()]);
        }
    }
}
