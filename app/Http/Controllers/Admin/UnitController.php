<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeasurementUnit\StoreMeasurementUnitRequest;
use App\Http\Requests\MeasurementUnit\UpdateMeasurementUnitRequest;
use App\Models\MeasurementUnit;
use App\Services\UnitService;
use Illuminate\Http\Request;
use Throwable;

class UnitController extends Controller
{
    public function __construct(
        private readonly UnitService $unitService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $units = $this->unitService->list();

        if ($request->ajax()) {
            $data['columns']    = $request->columns;
            $data['order']      = $request->order[0]['column'];
            $data['orderBy']    = $data['columns'][$data['order']]["name"];
            $data['orderDir']   = $request->order[0]['dir'];
            $data['search']     = $request->search;

            return $this->unitService->listAjax($data);
        }

        return view('admin.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create Measurement Unit';

        $pageAction = 'Create';

        $formTitle = 'Create Measurement Unit';

        return view('admin.units.create', compact('pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeasurementUnitRequest $request)
    {
        $data = $request->validated();

        $unit = $this->unitService->create($data);

        return redirect()->route('admin.units.show', ['unit' => $unit])->with('success', 'Measurement Unit created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(MeasurementUnit $unit)
    {
        return view('admin.units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MeasurementUnit $unit)
    {
        $pageTitle = 'Edit Measurement Unit';

        $pageAction = 'Edit';

        $formTitle = 'Edit Measurement Unit';

        return view('admin.units.edit', compact('unit', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeasurementUnitRequest $request, MeasurementUnit $unit)
    {
        $data = $request->validated();

        $unit = $this->unitService->update($unit, $data);

        return redirect()->route('admin.units.show', ['unit' => $unit])->with('success', 'Measurement Unit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeasurementUnit $unit)
    {
        return redirect()->route('admin.units.index');
        
        try {
            $result = $this->unitService->delete($unit);

            if (!$result) {
                return redirect()->route('admin.units.index')->with('error', 'Measurement Unit can\'t be deleted');
            }

            return redirect()->route('admin.units.index')->with('success', 'Measurement Unit deleted successfully');
        } catch (Throwable $throwable) {
            return redirect()->route('admin.units.index')->with(['error' => $throwable->getMessage()]);
        }
    }
}
