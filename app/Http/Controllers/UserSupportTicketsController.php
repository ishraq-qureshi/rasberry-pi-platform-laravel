<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSupportTicket;

class UserSupportTicketsController extends Controller
{
    public function view (Request $request) {
        $user = Auth::user();

        if($user->hasRole('superadmin')){
            $supportTickets = UserSupportTicket::where('parent_id', NULL)->get();                
        } else {
            $supportTickets = $user->supportTickets;        
        }

        return view('livewire.pages.manage-support-tickets.view', compact('supportTickets'));
    }

    public function create (Request $request) {
        return view('livewire.pages.manage-support-tickets.edit');
    }

    public function save (Request $request) {

        $request->validate([
            "title" => "required",
            "message" => "required"
        ]);

        $user = Auth::user();

        UserSupportTicket::create(array(
            "title" => $request->title,
            "message" => $request->message,
            "user_id" => $user->id,            
        ));

        return redirect()->route('user-tickets.view')->with("success", "Record(s) saved successfully.");
    }

    public function details ($id) {        

        $supportTicket = UserSupportTicket::where('id', $id)->first();

        $replies = UserSupportTicket::where('parent_id', $id)->get();

        return view('livewire.pages.manage-support-tickets.details', compact("supportTicket", "replies"));
    }

    public function reply (Request $request) {

        $request->validate([
            "message" => "required"
        ]);

        $user = Auth::user();

        UserSupportTicket::create(array(
            "title" => "Reply",
            "message" => $request->message,
            "user_id" => $user->id,        
            "parent_id" => $request->id    
        ));

        return redirect()->route('user-tickets.details', ['id' => $request->id])->with("success", "Record(s) saved successfully.");
    }
}
