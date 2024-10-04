<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\UserSubscription;
use App\Models\Payment;
use App\Models\User;
use Stripe\Webhook;
use Stripe\Stripe;


class StripeController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Retrieve the event from Stripe
        $event = $request->all();
        Log::info('Checkout session started', $event);

        // Retrieve the webhook signature from the headers
        $signature = $request->header('Stripe-Signature');

        // Retrieve the raw payload
        $payload = $request->getContent();

        try {
            // Verify the webhook signature
            $event = Webhook::constructEvent(
                $payload, $signature, env('STRIPE_WEBHOOK_SECRET')
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        // Handle the event types
        switch ($event['type']) {
            case 'checkout.session.completed':
                // Handle successful checkout session completion
                $session = $event['data']['object'];

                $user = User::where('email', $event['data']['object']['customer_details']['email'])->first();
                $subscription = UserSubscription::where(['user_id' => $user->id, 'status' => 'pending'])->first();

                if (isset($session['invoice'])) {
                    // Retrieve the invoice object from Stripe
                    
                    $invoice = \Stripe\Invoice::retrieve($session['invoice']);
    
                    // Extract the invoice URL (hosted or PDF)
                    $invoiceUrl = $invoice->invoice_pdf ?? $invoice->hosted_invoice_url;
    
                    // Log the invoice URL
                    Log::info('Invoice URL: ' . $invoiceUrl);
    
                    // Send the invoice URL to the user or return it in the response as needed
                    // You could store this in your DB or pass it in the success route
                    // Example: $user->notify(new InvoiceUrlNotification($invoiceUrl));
                }

                Payment::create(array(
                    'user_id' => $user->id,
                    'user_subscription_id' => $subscription->id,
                    'status' => "succeeded",
                    'price' => $subscription->price,
                    'stripe_response' => json_encode($session),
                    'invoice_url' => $invoiceUrl ?? null,
                ));
                
                $subscription->stripe_subscription_id = $session['subscription'];
                $subscription->status = 'active';
                $subscription->save();

                Log::info("Event Data:" . json_encode($event));

                


                Log::info('Checkout session completed: ' . $session['id']);
                // You can activate the subscription in your database here
                break;

            case 'invoice.payment_succeeded':
                // Handle successful payment for a subscription invoice
                $invoice = $event['data']['object'];
                Log::info('Invoice payment succeeded: ' . $invoice['id']);

                // Update the subscription status in your database here
                break;

            case 'invoice.payment_failed':
                // Handle failed payment for a subscription invoice
                $invoice = $event['data']['object'];
                Log::info('Invoice payment failed: ' . $invoice['id']);
                // Update the subscription status in your database here
                break;

            case 'customer.subscription.deleted':
                // Handle subscription cancellation
                $subscription = $event['data']['object'];
                Log::info('Subscription canceled: ' . $subscription['id']);
                // Update the subscription status in your database here
                break;

            // Handle other event types
            default:
                Log::warning('Unhandled event type: ' . $event['type']);
                break;
        }

        // Return a response to acknowledge receipt of the event
        return response()->json(['status' => 'success']);
    }

}