<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\WorkCategoryClassificationService;
use Illuminate\Http\Request;

class WorkCategoryController extends Controller
{
    public function __construct(
        protected WorkCategoryClassificationService $workCategoryClassificationService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $workCategories = $this->workCategoryClassificationService->listForSelect();
        return view('web.workCategories.index', compact('workCategories'));
    }
}
