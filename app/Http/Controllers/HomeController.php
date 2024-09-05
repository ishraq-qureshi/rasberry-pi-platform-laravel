<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class HomeController extends Controller
{
    public function view(){

        $subscriptionPlans = SubscriptionPlan::all();

        return view("livewire.pages.home.view", compact("subscriptionPlans"));
    }
}
