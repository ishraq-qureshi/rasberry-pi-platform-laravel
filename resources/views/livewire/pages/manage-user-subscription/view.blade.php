<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('messages.select_your_plan') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          @if(isset(auth()->user()->subscriptions) && count(auth()->user()->subscriptions) > 0 && !auth()->user()->subscriptions[0]->is_trial && auth()->user()->subscriptions[0]->status === 'active')          
            <div class="flex justify-end mb-4">
              <a href="{{ route('user-subscription.cancel_sub') }}" class="hover:bg-red-400 bg-red-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">{{ __('messages.cancel_subscription') }}</a>
            </div>
          @endif
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">                  
                  <div class="flex gap-4 flex-wrap">
                    @foreach ($subscriptionPlans as $plan)
                      @php
                        $activePlanId = 0;
                        if(isset(auth()->user()->subscriptions) && count(auth()->user()->subscriptions) > 0 && auth()->user()->subscriptions[0]->status === "active"):
                          $activePlanId = auth()->user()->subscriptions[0]->plan->id;
                        endif
                      @endphp
                      <div id="subscription_{{ $plan->id }}" data-id="{{ $plan->id }}" data-price="{{ $plan->isDiscount ? $plan->discount_price : $plan->price }}" class="subscription_box max-w-[calc(100%/3-20px)] flex flex-col p-6 mx-auto w-full text-center text-gray-900 bg-white rounded-md border border-gray-200">
                        <h3 class="mb-4 text-2xl font-semibold">{{ $plan->plan_name }}</h3>
                        <p class="font-light text-gray-500">{{ __("messages.allowed_devices") }}: {{ $plan->allowed_rasberry }} {{ __("messages.units") }}</p>
                        <div class="flex flex-col gap-2 my-4">
                          @if($plan->isDiscount && !$plan->is_trial)
                            <p class="text-gray-400 line-through">€{{ number_format($plan->price, 2) }}</p>
                          @endif
                          <div class="flex justify-center items-baseline">
                            @if($plan->is_trial)
                              <span class="mr-2 text-5xl font-extrabold">{{ __("messages.free") }}</span>
                            @else
                              <span class="mr-2 text-5xl font-extrabold">€{{ number_format($plan->isDiscount ? $plan->discount_price : $plan->price, 2) }}</span>
                              <span class="text-gray-500 dark:text-gray-400">/{{ __("messages.month") }}</span>
                            @endif
                          </div>
                        </div>
                        <ul role="list" class="mb-8 space-y-4 text-left">
                          @foreach(unserialize($plan->features) as $feature)
                          <li class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>{{ $feature }}</span>
                          </li>
                          @endforeach
                        </ul>
                        <button type="button" class="selectSubscriptionPlan text-white {{ $activePlanId === $plan->id ? "bg-green cursor-not-allowed" : "bg-blue-600" }} hover:bg-primary-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">{{ $activePlanId === $plan->id ? __("messages.active") : __("messages.select") }}</button>
                      </div>
                    @endforeach                    
                  </div>
                  <div class="flex justify-center mt-8">
                    <button id="buyPlan" class="text-white bg-black hover:bg-primary-700 font-medium rounded-lg text-lg px-5 py-2.5 text-center w-[300px]">{{ __("messages.get_started") }}</button>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script>
    jQuery(function() {

      let id = null;
      let price = null;

      const selectText = "{{ __('messages.select') }}";
      const selectedText = "{{ __('messages.selected') }}";

      jQuery('.selectSubscriptionPlan').click(function(){
        id = jQuery(this).parents('.subscription_box').attr("data-id");
        price = jQuery(this).parents('.subscription_box').attr("data-price");
        
        if(jQuery(this).hasClass('active')) {
          jQuery('.selectSubscriptionPlan').removeClass('active');
          jQuery(this).parents('.subscription_box').removeClass('border-blue-600')
          jQuery(this).text(selectText)
        } else {
          jQuery('.selectSubscriptionPlan').removeClass('active');
          jQuery('.subscription_box').removeClass('border-blue-600');
          jQuery(this).parents('.subscription_box').addClass('border-blue-600')
          jQuery(this).addClass('active');
          jQuery(this).text(selectedText)
        }
      });

      jQuery("#buyPlan").click(function(){
        location = `{{ route('user-subscription.checkout') }}/${id}`;
        console.log(location);
      })
    });
  </script>
</x-app-layout>
