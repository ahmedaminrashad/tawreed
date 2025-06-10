<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('country')->latest();

        if ($request->ajax()) {
            return datatables()->of($users)
                ->addColumn('action', function ($user) {
                    return view('admin.users.actions', compact('user'));
                })
                ->addColumn('type', function ($user) {
                    return $user->type->value;
                })
                ->addColumn('country', function ($user) {
                    return $user->country ? $user->country->name : '-';
                })
                ->addColumn('verification', function ($user) {
                    if ($user->type->value === 'company') {
                        return $user->company_verified_at ? 'Verified' : 'Not Verified';
                    }
                    return $user->email_verified_at ? 'Verified' : 'Not Verified';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.index');
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.users.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['individual', 'company'])],
            'full_name' => 'required_if:type,individual|nullable|string|max:191',
            'company_name' => 'required_if:type,company|nullable|string|max:191',
            'email' => 'required|email|unique:users',
            'country_code' => 'nullable|string|max:191',
            'phone' => 'nullable|string|max:191',
            'image' => 'nullable|image|max:2048',
            'commercial_registration_number' => 'nullable|string|max:191',
            'country_id' => 'nullable|exists:countries,id',
            'address' => 'nullable|string|max:191',
            'latitude' => 'nullable|string|max:191',
            'longitude' => 'nullable|string|max:191',
            'company_desc' => 'nullable|string',
            'password' => 'required|string|min:8',
            'email_notify' => 'boolean',
            'push_notify' => 'boolean',
            'tax_card_number' => 'nullable|string|max:191',
            'commercial_registration_file' => 'nullable|file|max:5120',
            'company_profile' => 'nullable|file|max:5120',
            'tax_card_file' => 'nullable|file|max:5120',
            'iban_file' => 'nullable|file|max:5120',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        if ($request->hasFile('image')) {
            $user->uploadFile('image', $request->file('image'));
        }

        if ($request->hasFile('commercial_registration_file')) {
            $user->uploadFile('commercial_registration_file', $request->file('commercial_registration_file'));
        }

        if ($request->hasFile('company_profile')) {
            $user->uploadFile('company_profile', $request->file('company_profile'));
        }

        if ($request->hasFile('tax_card_file')) {
            $user->uploadFile('tax_card_file', $request->file('tax_card_file'));
        }

        if ($request->hasFile('iban_file')) {
            $user->uploadFile('iban_file', $request->file('iban_file'));
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $countries = Country::all();
        return view('admin.users.edit', compact('user', 'countries'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['individual', 'company'])],
            'full_name' => 'required_if:type,individual|nullable|string|max:191',
            'company_name' => 'required_if:type,company|nullable|string|max:191',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'country_code' => 'nullable|string|max:191',
            'phone' => 'nullable|string|max:191',
            'image' => 'nullable|image|max:2048',
            'commercial_registration_number' => 'nullable|string|max:191',
            'country_id' => 'nullable|exists:countries,id',
            'address' => 'nullable|string|max:191',
            'latitude' => 'nullable|string|max:191',
            'longitude' => 'nullable|string|max:191',
            'company_desc' => 'nullable|string',
            'password' => 'nullable|string|min:8',
            'email_notify' => 'boolean',
            'push_notify' => 'boolean',
            'tax_card_number' => 'nullable|string|max:191',
            'commercial_registration_file' => 'nullable|file|max:5120',
            'company_profile' => 'nullable|file|max:5120',
            'tax_card_file' => 'nullable|file|max:5120',
            'iban_file' => 'nullable|file|max:5120',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        if ($request->hasFile('image')) {
            $user->uploadFile('image', $request->file('image'));
        }

        if ($request->hasFile('commercial_registration_file')) {
            $user->uploadFile('commercial_registration_file', $request->file('commercial_registration_file'));
        }

        if ($request->hasFile('company_profile')) {
            $user->uploadFile('company_profile', $request->file('company_profile'));
        }

        if ($request->hasFile('tax_card_file')) {
            $user->uploadFile('tax_card_file', $request->file('tax_card_file'));
        }

        if ($request->hasFile('iban_file')) {
            $user->uploadFile('iban_file', $request->file('iban_file'));
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function verifyCompany(User $user)
    {
        $user->update(['company_verified_at' => now()]);
        return redirect()->back()->with('success', 'Company verified successfully');
    }
} 