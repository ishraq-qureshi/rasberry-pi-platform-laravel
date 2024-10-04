<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Carbon\Carbon;

new class extends Component
{
    
    public $payments = [];
    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $subscriptions = Auth::user()->subscriptions;
        
        if(isset($subscriptions) && count($subscriptions) > 0) {
          foreach ($subscriptions as $subscription) {
            $tmp_data = [];
            $tmp_data['plan_name'] = $subscription->plan->plan_name;
            
            foreach ($subscription->payments as $payment) {
              $tmp_data['status'] = $payment->status;
              $tmp_data['price'] = $payment->price;
              $tmp_data['invoice_url'] = $payment->invoice_url;
              $tmp_data['date'] = Carbon::parse($payment->created_at)->format("Y-m-d");
            }

            $this->payments[] = $tmp_data;
          }
        }
    }    
}; ?>

<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900">
        {{ __('messages.my_invoices') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600">
        {{ __("messages.my_invoices_desc") }}
    </p>
</header>
<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
  <thead class="text-gray-400 uppercase">
      <tr>
          <th scope="col" class="px-6 py-4">
            {{ __('messages.plan_name') }}
          </th>
          <th scope="col" class="px-6 py-4 text-center">
            {{ __('messages.price') }}
          </th>
          <th scope="col" class="px-6 py-4 text-center">
            {{ __('messages.status') }}
          </th>
          <th scope="col" class="px-6 py-4 text-center">
            {{ __('messages.date') }}
          </th>                    
          <th scope="col" class="px-6 py-4 text-center">
            {{ __('messages.invoice') }}
        </th>
      </tr>
  </thead>
  <tbody>
    @if(isset($payments) && count($payments) > 0)
      @foreach($payments as $payment)
        <tr class="bg-white border-b">                                
          <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
            {{ $payment['plan_name'] }}
            </th>
            <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
              {{ $payment['price'] }}
            </td>
            <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
              {{ $payment['status'] }}
            </td>
            <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
              {{ $payment['date'] }}
            </td>
            <td class="flex items-center justify-center px-6 py-4">
              <a href="{{ $payment['invoice_url'] }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __("messages.download_invoice") }}</a>              
          </td>
        </tr>                          
        @endforeach
      @else
        <tr>
          <td colspan="5">
            <p class="text-center">{{ __("messages.no_record") }}</p>
          </td>
        </tr>
      @endif
  </tbody>
</table>
</section>
