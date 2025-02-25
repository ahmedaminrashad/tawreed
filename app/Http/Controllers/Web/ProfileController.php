<?php

namespace App\Http\Controllers\Web;

use App\Enums\TenderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\Notification\StoreProfileNotificationsRequest;
use App\Http\Requests\Profile\StoreProfileRequest;
use App\Http\Requests\Profile\UpdateProfileEmailRequest;
use App\Http\Requests\Profile\UpdateProfilePasswordRequest;
use App\Http\Requests\Profile\VerifyProfileEmailRequest;
use App\Services\CountryService;
use App\Services\TenderService;
use App\Services\Web\UserService;
use App\Services\WorkCategoryClassificationService;
use App\Traits\CustomResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use CustomResponse;

    public function __construct(
        protected TenderService $tenderService,
        protected CountryService $countryService,
        protected UserService $userService,
        protected WorkCategoryClassificationService $workCategoryClassificationService
    ) {}

    public function index()
    {
        $user = auth()->user();
        return view('web.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        $userCategories = $user->userCategories()->pluck('id')->toArray();
        $countries = $this->countryService->listForSelect();
        $countries_codes = $this->countryService->listCountryCodeForSelect();
        $categories = $this->workCategoryClassificationService->listForSelect();
        return view('web.profile.edit', compact('user', 'userCategories', 'countries', 'countries_codes', 'categories'));
    }

    // public function store(Request $request)
    public function store(StoreProfileRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();

        if ($data['country_code']) {
            $data['country_code'] = $this->countryService->getById($data['country_code'])->country_code;
        }

        $user = auth()->user();

        $result = $this->userService->update($user, $data);

        if (is_array($result) && array_key_exists('error', $result)) {
            return redirect()->back()->with(['error' => $result['error']]);
        }

        return redirect()->route('profile.index')->with(['success' => 'Profile updated successfully']);
    }

    public function tenders()
    {
        $user = auth()->user();
        $data['userId'] = auth()->id();
        $data['status'] = TenderStatus::IN_PROGRESS->value;
        $tenders = $this->tenderService->list($data);
        return view('web.profile.tenders', compact('user', 'tenders'));
    }

    public function settings()
    {
        $user = auth()->user();
        return view('web.profile.settings', compact('user'));
    }

    public function storeNotifications(StoreProfileNotificationsRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();

        $result = $this->userService->update($user, $data);

        if (is_array($result) && array_key_exists('error', $result)) {
            return redirect()->back()->with(['error' => $result['error']]);
        }

        return redirect()->route('profile.settings.index')->with(['success' => 'Profile Notifications updated successfully']);
    }

    public function updatePassword(UpdateProfilePasswordRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();

        $result = $this->userService->updatePassword($user, $data);

        if ((is_array($result) && array_key_exists('error', $result))) {
            return $this->failure(['error' => $result['error']], 'Error in Update User Password');
        }

        if (is_numeric($result) && $result == 0) {
            return $this->failure(['error' => 'Old Password not matched'], 'Error in Update User Password');
        }

        return $this->success([], 'User password updated successfully');
    }

    public function updateProfileEmail(UpdateProfileEmailRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();

        $result = $this->userService->updateEmail($user, $data);

        if ((is_array($result) && array_key_exists('error', $result))) {
            return $this->failure(['error' => $result['error']], 'Error in Update User Email');
        }

        if (is_numeric($result) && $result == 0) {
            return $this->failure(['error' => 'Error in Update User Email'], 'Error in Update User Email');
        }

        return $this->success([], 'User Email updated successfully');
    }

    public function verifyUpdateEmail(VerifyProfileEmailRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();

        $result = $this->userService->verifyEmailUpdate($user, $data);

        if ((is_array($result) && array_key_exists('error', $result))) {
            return $this->failure(['error' => $result['error']], 'Error in Update User Email');
        }

        if (is_numeric($result) && $result == 0) {
            return $this->failure(['error' => 'Error in Update User Email'], 'Error in Update User Email');
        }

        return $this->success([], 'User Email updated successfully');
    }
}
