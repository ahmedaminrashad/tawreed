<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\WorkCategoryClassification;
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
    public function activities(WorkCategoryClassification $category_id)
    {
        return $this->workCategoryClassificationService->activities($category_id);

    }
}
