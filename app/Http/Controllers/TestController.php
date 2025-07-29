<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Models\ActivityClassification;
use App\Models\Admin;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function test()
    {

        return  base_path('/');
        return Tender::query()->with('items')->find(18);

        $users = User::query()->get();

        foreach ($users as $key=>$user) {
            $user->update(['email'=>"user{$key}@user.com"]);

        }


     return   User::query()->update(['password'=>bcrypt('12345678')]);


        return 'sss';
        return Tender::query()
            ->with('proposals')
            ->find(17);
        return bcrypt('12345678');
//        return Tender::query()->find(16);
        return User::query()->update(['password'=>bcrypt('12345678')]);

       return User::query()->create([
            'name' => 'John Doe',
            'email'=>'mail3@gmail.com',
            'password'=>bcrypt('12345678'),
            'phone'=>'01017213866',
           'type'=>UserType::COMPANY->value
        ]);



        return ActivityClassification::query()->get();

      return  User::query()->update(['password' => bcrypt('1234567890')]);
    }
}
