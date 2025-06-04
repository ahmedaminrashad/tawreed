<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Models\ActivityClassification;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function test()
    {

       return User::query()->create([
            'name' => 'John Doe',
            'email'=>'mail3@gmail.com',
            'password'=>bcrypt('12345678'),
            'phone'=>'01017213866',
           'type'=>UserType::COMPANY->value
        ]);

        return Tender::query()->latest()->first();

        return ActivityClassification::query()->get();

      return  User::query()->update(['password' => bcrypt('1234567890')]);
    }
}
