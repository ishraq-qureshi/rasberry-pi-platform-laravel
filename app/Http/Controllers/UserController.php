<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function view (Request $request) {
        $users = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'superadmin');
        })->get();

        return view('livewire.pages.manage-users.view', compact('users'));
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
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::where('id', $request->id)->update(array(
            'name'  => $request->user_name,
            'password' => $validated['password']
        ));
        
        return redirect()->route('users.view')->with("success", "Record(s) saved successfully.");

    }
}
