<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Product;
use Stripe\Price;
use Stripe\Exception\ApiErrorException;

class UserSubscriptionController extends Controller
{
    public function view(Request $request) {

        $subscriptionPlans = SubscriptionPlan::all();

        return view('livewire.pages.manage-user-subscription.view', compact('subscriptionPlans'));
    }

    public function checkout(Request $request, $plan_id)
    {
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));

        // Get the logged-in user
        $user = Auth::user();

        $plan = SubscriptionPlan::where('id', $plan_id)->first();

        if($plan) {
            // Define the product details dynamically
            $productName = $plan->plan_name;
            $productDescription = "Subscription for plan";
            $unitAmount = $plan->isDiscount ? $plan->discount_price * 100 : $plan->price * 100; // 20.00 USD
            $currency = 'eur';

            try {

                if(!$plan->is_trial) {
                    // Create a product on Stripe
                    $product = Product::create([
                        'name' => $productName,
                        'description' => $productDescription,
                    ]);
    
                    // Create a price plan for the product
                    $price = Price::create([
                        'unit_amount' => $unitAmount,
                        'currency' => $currency,
                        'recurring' => ['interval' => 'month'],
                        'product' => $product->id,
                    ]);
    
                    // Create or retrieve Stripe customer
                    $customerId = $user->stripe_customer_id;
    
                    if (!$customerId) {
                        $customer = Customer::create([
                            'email' => $user->email,
                            'name' => $user->name,
                        ]);
    
                        $customerId = $customer->id;
                        $user->stripe_customer_id = $customerId;
                        // $user->save();
                    }
    
                    // Create a new Stripe Checkout Session for a subscription
                    $checkout_session = Session::create([
                        'payment_method_types' => ['card'],
                        'customer' => $customerId, // Attach the customer to the session
                        'line_items' => [[
                            'price' => $price->id, // Use the dynamically created price ID
                            'quantity' => 1,
                        ]],
                        'mode' => 'subscription',
                        'success_url' => route('user-subscription.success'),
                        'cancel_url' => route('user-subscription.cancel'),
                    ]);
                }

                $subscription = UserSubscription::where([
                    "user_id" => $user->id,                    
                ])->first();

                if($subscription) {
                    
                    $subscription->status = $plan->is_trial ? "active" : "pending";
                    $subscription->subscription_id = $plan->id;
                    $subscription->price = $plan->isDiscount ? $plan->discount_price : $plan->price;
                    $subscription->save();

                } else {
                    UserSubscription::create(array(
                        "user_id" => $user->id,
                        "subscription_id" => $plan->id,
                        "price" => $plan->isDiscount ? $plan->discount_price : $plan->price,
                        "status" => $plan->is_trial ? "active" : "pending"
                    ));
                }

                if($plan->is_trial) {
                    return redirect()->route('user-subscription.success');
                }
                // Redirect to Stripe Checkout
                return redirect($checkout_session->url);

            } catch (ApiErrorException $e) {
                return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
            }
        }
    }

    public function success(Request $request)
    {
        return view('livewire.pages.manage-user-subscription.success');
    }

    public function cancel()
    {
        return view('livewire.pages.manage-user-subscription.cancel');
    }

    public function cancel_sub() {
        // Set Stripe API key
    Stripe::setApiKey(config('services.stripe.secret'));

    // Get the logged-in user
    $user = Auth::user();

    // Retrieve the user's current subscription (assumes you store the subscription ID)
    $userSubscription = UserSubscription::where('user_id', $user->id)->first();

    if ($userSubscription && $userSubscription->stripe_subscription_id) {
        try {
            // Retrieve the Stripe subscription
            $subscription = \Stripe\Subscription::retrieve($userSubscription->stripe_subscription_id);

            // Cancel the subscription immediately or at the end of the billing cycle
            $subscription->cancel(); // or $subscription->cancel(['at_period_end' => true]);

            // Update the status in your UserSubscription table
            $userSubscription->status = 'cancelled';
            $userSubscription->save();

            return back()->with('success', 'Your subscription has been cancelled successfully.');

        } catch (ApiErrorException $e) {
            return back()->withErrors(['error' => 'Failed to cancel the subscription: ' . $e->getMessage()]);
        }
    } else {
        return back()->withErrors(['error' => 'No active subscription found.']);
    }
    }
}

