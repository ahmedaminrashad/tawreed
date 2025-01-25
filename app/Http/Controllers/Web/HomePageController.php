<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use App\Services\WorkCategoryClassificationService;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function __construct(
        protected SettingService $settingService,
        protected WorkCategoryClassificationService $workCategoryClassificationService,
    ) {}

    public function index(Request $request)
    {
        $workCategories = $this->workCategoryClassificationService->listForSelect(3);
        return view('web.index', compact('workCategories'));
    }

    public function about(Request $request)
    {
        return view('web.about');
    }

    public function privacy(Request $request)
    {
        return view('web.privacy');
    }

    public function terms(Request $request)
    {
        return view('web.terms');
    }

    public function contact(Request $request)
    {
        $email = $this->settingService->getByKey('email')->value;
        $phone = $this->settingService->getByKey('phone')->value;

        return view('web.contact', compact(
            'email',
            'phone',
        ));
    }
}
