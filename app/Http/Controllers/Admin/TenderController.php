<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Models\Country;
use App\Models\City;
use App\Models\Company;
use App\Models\User;
use App\Models\WorkCategoryClassification;
use App\Models\ActivityClassification;
use App\Enums\TenderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $query = Tender::with(['country', 'city', 'workCategoryClassification', 'activityClassification', 'user'])
            ->withCount('proposals');

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $tenders = $query->paginate(10);
        $users = \App\Models\User::all();

        return view('admin.tenders.index', compact('tenders', 'users'));
    }

    public function create()
    {
        $countries = Country::all();
        $cities = City::all();
        $categories = WorkCategoryClassification::all();
        $activities = ActivityClassification::all();
        $statuses = TenderStatus::cases();

        return view('admin.tenders.create', compact(
            'countries',
            'cities',
            'categories',
            'activities',
            'statuses'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after:contract_start_date',
            'closing_date' => 'required|date|before:contract_start_date',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'category_id' => 'required|exists:work_category_classifications,id',
            'activity_id' => 'required|exists:activity_classifications,id',
            'status' => 'required|in:' . implode(',', array_column(TenderStatus::cases(), 'value')),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tender = Tender::create([
            'subject' => $request->subject,
            'contract_start_date' => $request->contract_start_date,
            'contract_end_date' => $request->contract_end_date,
            'closing_date' => $request->closing_date,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'category_id' => $request->category_id,
            'activity_id' => $request->activity_id,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.tenders.index')
            ->with('success', __('admin.tender_created'));
    }

    public function edit(Tender $tender)
    {
        $countries = Country::all();
        $cities = City::all();
        $categories = WorkCategoryClassification::all();
        $activities = ActivityClassification::all();
        $statuses = TenderStatus::cases();

        return view('admin.tenders.edit', compact(
            'tender',
            'countries',
            'cities',
            'categories',
            'activities',
            'statuses'
        ));
    }

    public function update(Request $request, Tender $tender)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after:contract_start_date',
            'closing_date' => 'required|date|after:contract_start_date',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'category_id' => 'required|exists:classifications,id',
            'activity_id' => 'required|exists:activity_classifications,id',
            'status' => 'required|in:' . implode(',', array_column(TenderStatus::cases(), 'value')),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tender->update([
            'subject' => $request->subject,
            'contract_start_date' => $request->contract_start_date,
            'contract_end_date' => $request->contract_end_date,
            'closing_date' => $request->closing_date,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'category_id' => $request->category_id,
            'activity_id' => $request->activity_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tenders.index')
            ->with('success', __('admin.tender_updated'));
    }

    public function destroy(Tender $tender)
    {
        $tender->delete();

        return redirect()->route('admin.tenders.index')
            ->with('success', __('admin.tender_deleted'));
    }
}
