<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function test()
    {
      return  User::query()->update(['password' => bcrypt('1234567890')]);
    }
}
