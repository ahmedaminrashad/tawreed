<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
use App\Models\City;
use App\Services\CityService;
use App\Services\CountryService;
use Illuminate\Http\Request;
use Throwable;

class CityController extends Controller
{
    public function __construct(
        private readonly CityService $cityService,
        private readonly CountryService $countryService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cities = $this->cityService->list();

        if ($request->ajax()) {
            $data['columns']    = $request->columns;
            $data['order']      = $request->order[0]['column'];
            $data['orderBy']    = $data['columns'][$data['order']]["name"];
            $data['orderDir']   = $request->order[0]['dir'];
            $data['search']     = $request->search;

            return $this->cityService->listAjax($data);
        }

        return view('admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create City';

        $pageAction = 'Create';

        $formTitle = 'Create City';

        $countries = $this->countryService->listForSelect();

        return view('admin.cities.create', compact('countries', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request)
    {
        $data = $request->validated();

        $city = $this->cityService->create($data);

        return redirect()->route('admin.cities.show', ['city' => $city])->with('success', 'City created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        return view('admin.cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $pageTitle = 'Edit City';

        $pageAction = 'Edit';

        $formTitle = 'Edit City';

        $countries = $this->countryService->listForSelect();

        return view('admin.cities.edit', compact('city', 'countries', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        $data = $request->validated();

        $city = $this->cityService->update($city, $data);

        return redirect()->route('admin.cities.show', ['city' => $city])->with('success', 'City updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        return redirect()->route('admin.cities.index');
        
        try {
            $result = $this->cityService->delete($city);

            if (!$result) {
                return redirect()->route('admin.cities.index')->with('error', 'City can\'t be deleted');
            }

            return redirect()->route('admin.cities.index')->with('success', 'City deleted successfully');
        } catch (Throwable $throwable) {
            return redirect()->route('admin.cities.index')->with(['error' => $throwable->getMessage()]);
        }
    }
}
