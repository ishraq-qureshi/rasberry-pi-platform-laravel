<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubUser;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;

class UserController extends Controller
{
    public function view (Request $request) {

        $currentUser = Auth::user();
        
        if($currentUser->hasRole("superadmin")) {
            $users = User::whereDoesntHave('roles', function($query) {
                $query->where('name', 'superadmin');
            })->get();
        } else {
            $users = $currentUser->subUsers()->with('user')->get();
        }

        return view('livewire.pages.manage-users.view', compact('users'));
    }

    public function create (Request $request) {

        $plans = SubscriptionPlan::all();

        $subUsers = Auth::user()->subUsers;
        $subscriptions = Auth::user()->subscriptions;
        if($subscriptions && count($subscriptions) > 0) {
            $allowedUsers = $subscriptions[0]->plan->allowed_users;                        
            if(count($subUsers) >= $allowedUsers) {
                return redirect()->route('users.view')->with("error", "You had exceed limit of sub admins");
            }
        }
        
        return view('livewire.pages.manage-users.edit', compact('plans'));
    }

    public function edit (Request $request, $id) {
        $user = User::where('id', $id)->first();
        $plans = SubscriptionPlan::all();
        return view('livewire.pages.manage-users.edit', compact('user', 'plans'));
    }

    public function delete (Request $request, $id) {
        $user = User::where('id', $id)->first();
        return view('livewire.pages.manage-users.delete', compact('user'));
    }

    public function destroy (Request $request, $id) {
        User::where('id', $id)->delete();
        return redirect()->route('users.view')->with("success", "Record(s) deleted successfully.");
    }

    public function save(Request $request) {


        $currentUser = Auth::user();

        $validated = $request->validate([
            'user_name' => ['required', 'string', 'max:255'],
            
            // Make email required only if request->id is not present
            'email' => [
                isset($request->id) ? 'sometimes' : 'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                isset($request->id) ? Rule::unique('users')->ignore($request->id) : Rule::unique('users'),
            ],
            
            // Make password required only if request->id is not present
            'password' => [
                isset($request->id) ? 'nullable' : 'required',
                'confirmed',
                Rules\Password::defaults(),
            ],

            'subscription_plan' => [
                $currentUser->hasRole("superadmin") ? "required" : "nullable",
            ],
        
            // Optional fields
            'surname' => ['required', 'string'],
            'telephone' => ['required', 'string'],
            'billing_address' => ['nullable', 'string'],
            'postal_address' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string'],
        ]);
        
        if(isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        if($request->id) {

            $userData = [
                'name' => $request->user_name,
                'surname' => $request->surname,
                'telephone' => $request->telephone,
                'billing_address' => $request->billing_address,
                'postal_address' => $request->postal_address,
                'company_name' => $request->company_name,
            ];
            
            // Only include password if it's set
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            
            $user = User::where('id', $request->id)->update($userData);

            if($currentUser->hasRole("superadmin")) { 
                
                $userSubscription = UserSubscription::where('user_id', $request->id)->first();                
                $plan = SubscriptionPlan::where('id', $validated['subscription_plan'])->first();
                
                $userSubscription->subscription_id = $plan->id;
                $userSubscription->price = $plan->price;
                $userSubscription->status = "active";

                $userSubscription->save();
            }
            
        } else {            
            $userData = [
                'name' => $request->user_name,
                'email' => $request->email,
                'surname' => $request->surname,
                'telephone' => $request->telephone,
                'billing_address' => $request->billing_address,
                'postal_address' => $request->postal_address,
                'company_name' => $request->company_name,
            ];
            
            // Only include password if it's set
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            
            $user = User::create($userData);

            if($currentUser->hasRole("superadmin")) {
                $user->assignRole("admin");
                
                $userSubscription = new UserSubscription();                
                $plan = SubscriptionPlan::where('id', $validated['subscription_plan'])->first();

                $userSubscription->user_id = $user->id;
                $userSubscription->subscription_id = $plan->id;
                $userSubscription->price = $plan->price;
                $userSubscription->status = "active";

                $userSubscription->save();

            } else {
                $user->assignRole("subadmin");
    
                SubUser::create(array(
                    'user_id' => $user->id,
                    'parent_user_id' => $currentUser->id,
                ));

            }

        }

        return redirect()->route('users.view')->with("success", "Record(s) saved successfully.");

    }
}
