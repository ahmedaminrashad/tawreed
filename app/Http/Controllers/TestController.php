<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Models\ActivityClassification;
use App\Models\Admin;
use App\Models\Tender;
use App\Models\User;
use App\Services\Web\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function __construct(
        private readonly EmailService $emailService,
    ) {}

    public function test()
    {

     return  $user= User::query()->where('email','ahmedaminrashad@gmail.com')->first();
    $mail=  $this->emailService->sendWelcomeEmail($user);
      
      dd($mail);
        return bcrypt('12345678');
        return bcrypt('superAdmin@tawred2026');
        return 'ss';
//        return Tender::query()->with('items')->find(18);

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
