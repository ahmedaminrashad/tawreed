<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\Admin\UpdateAdminRequest;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Models\Country;
use App\Services\CountryService;
use Illuminate\Http\Request;
use Throwable;

class CountryController extends Controller
{
    public function __construct(
        private readonly CountryService $countryService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $countries = $this->countryService->list();

        if ($request->ajax()) {
            $data['columns']    = $request->columns;
            $data['order']      = $request->order[0]['column'];
            $data['orderBy']    = $data['columns'][$data['order']]["name"];
            $data['orderDir']   = $request->order[0]['dir'];
            $data['search']     = $request->search;

            return $this->countryService->listAjax($data);
        }

        return view('admin.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Create Country';

        $pageAction = 'Create';

        $formTitle = 'Create Country';

        return view('admin.countries.create', compact('pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request)
    {
        $data = $request->validated();

        $country = $this->countryService->create($data);

        return redirect()->route('admin.countries.show', ['country' => $country])->with('success', 'Country created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return view('admin.countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        $pageTitle = 'Edit Country';

        $pageAction = 'Edit';

        $formTitle = 'Edit Country';

        return view('admin.countries.edit', compact('country', 'pageTitle', 'pageAction', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $data = $request->validated();

        $country = $this->countryService->update($country, $data);

        return redirect()->route('admin.countries.show', ['country' => $country])->with('success', 'Country updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        try {
            $result = $this->countryService->delete($country);

            if (!$result) {
                return redirect()->route('admin.countries.index')->with('error', 'Country can\'t be deleted');
            }

            return redirect()->route('admin.countries.index')->with('success', 'Country deleted successfully');
        } catch (Throwable $throwable) {
            return redirect()->route('admin.countries.index')->with(['error' => $throwable->getMessage()]);
        }
    }
}
