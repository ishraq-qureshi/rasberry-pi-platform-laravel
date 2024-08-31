<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubUser;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


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
        $subUsers = Auth::user()->subUsers;
        $subscriptions = Auth::user()->subscriptions;
        if($subscriptions && count($subscriptions) > 0) {
            $allowedUsers = $subscriptions[0]->plan->allowed_users;                        
            if(count($subUsers) >= $allowedUsers) {
                return redirect()->route('users.view')->with("error", "You had exceed limit of sub admins");
            }
        }
        
        return view('livewire.pages.manage-users.edit');
    }

    public function edit (Request $request, $id) {
        $user = User::where('id', $id)->first();
        return view('livewire.pages.manage-users.edit', compact('user'));
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

        $validated = $request->validate([
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', isset($request->id) ? Rule::unique('users')->ignore($request->id) : Rule::unique('users')],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);        
        $validated['password'] = Hash::make($validated['password']);

        if($request->id) {

            $user = User::where('id', $request->id)->update(array(
                'name'  => $request->user_name,
                'password' => $validated['password']
            ));
        } else {

            $currentUser = Auth::user();
            
            $user = User::create(array(
                'name' => $request->user_name,
                'email' => $request->email,
                'password' => $validated['password']
            ));

            $user->assignRole("subadmin");

            SubUser::create(array(
                'user_id' => $user->id,
                'parent_user_id' => $currentUser->id,
            ));
        }

        return redirect()->route('users.view')->with("success", "Record(s) saved successfully.");

    }
}
