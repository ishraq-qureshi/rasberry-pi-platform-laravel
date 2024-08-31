<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckTrialSubscription
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
            $tial_user = $user->trialSubscription();
            
            if(!$tial_user) {
                return $next($request);
            }

            $subscription = $user->subscriptions()
                                ->whereHas('plan', function($query) {
                                    $query->where('is_trial', 1);
                                })
                                ->first();

            $subscriptionDate = Carbon::parse($subscription->created_at);
            $subscriptionEndDate = $subscriptionDate->addDays(14);
            $remainingDays = Carbon::now()->diffInDays($subscriptionEndDate, false);

            if ($remainingDays > 0) {
                // If user has a subscription and the payment is successful
                return $next($request);
            }
        }

        return redirect()->route('user-subscription.view'); // Change this to your desired route
    }
}
