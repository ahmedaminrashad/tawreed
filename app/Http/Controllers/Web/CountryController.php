<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(
        protected CountryService $countryService
    ) {}
    
    public function cities($country_id)
    {
        $cities = $this->countryService->cities($country_id);
        
        return $cities;
    }
}
