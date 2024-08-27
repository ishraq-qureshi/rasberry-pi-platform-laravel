<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;


class SubcriptionPlanController extends Controller
{
    public function view (Request $request) {
        $plans = SubscriptionPlan::all();

        return view('livewire.pages.manage-subscription-plan.view', compact('plans'));
    }

    public function create (Request $request) {
        return view('livewire.pages.manage-subscription-plan.edit');
    }

    public function edit (Request $request, $id) {
        $plan = SubscriptionPlan::where('id', $id)->first();
        return view('livewire.pages.manage-subscription-plan.edit', compact('plan'));
    }

    public function delete (Request $request, $id) {
        $plan = SubscriptionPlan::where('id', $id)->first();
        return view('livewire.pages.manage-subscription-plan.delete', compact('plan'));
    }

    public function destroy (Request $request, $id) {
        SubscriptionPlan::where('id', $id)->delete();
        return redirect()->route('subscription-plans.view')->with("success", "Record(s) deleted successfully.");
    }

    public function save(Request $request) {
        
        $request->validate([
            'plan_name' => 'required|max:255',
            'price' => 'required|numeric',
            'isDiscount' => 'boolean',
            'allowed_rasberry' => 'required|numeric',
            'discount_price' => 'required_if:isDiscount,1'
        ]);

        $data = array(
            "plan_name" => $request->plan_name,
            "price" => $request->price,
            "allowed_rasberry" => $request->allowed_rasberry,
            "isDiscount" => isset($request->isDiscount) ? true : false,
            "discount_price" => isset($request->isDiscount) ? $request->discount_price : null,
            "features" => isset($request->features) ? serialize($request->features) : null,
        );

        if($request->id) {
            $plan = SubscriptionPlan::where("id", $request->id)->update($data);
        } else {
            $plan = SubscriptionPlan::create($data);
        }

        return redirect()->route('subscription-plans.view')->with("success", "Record(s) saved successfully.");

    }
}
