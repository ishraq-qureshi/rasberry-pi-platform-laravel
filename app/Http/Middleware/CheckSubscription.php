<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if($user && $user->hasRole('superadmin')) {
            return $next($request);
        }

        if ($user) {                            
            if($user->hasRole('admin')) {
                $subscription = $user->subscriptions()
                                    ->whereHas('payments', function($query) {
                                        $query->where('status', 'succeeded');
                                    })
                                    ->first();
    
                $tial_user = $user->trialSubscription();
    
                if ($subscription || $tial_user) {
                    // If user has a subscription and the payment is successful
                    return $next($request);
                }
            } else {

                $subscription = $user->subUser->parentUser->subscriptions()
                                    ->whereHas('payments', function($query) {
                                        $query->where('status', 'succeeded');
                                    })
                                    ->first();
    
                $tial_user = $user->subUser->parentUser->trialSubscription();
    
                if ($subscription || $tial_user) {
                    // If user has a subscription and the payment is successful
                    return $next($request);
                }
            }

        }

        // Redirect to a specific route if no subscription or no successful payment
        return redirect()->route('user-subscription.view'); // Change this to your desired route
    }
}
