<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Manage Subscription Plans') }}
        </h2>
        <a href="{{ route('subscription-plans.create') }}" class="py-2 px-6 bg-black text-white rounded-md">Create New Plan</a>        
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">        
          @if(session('success'))
            <div class="p-4 mb-4 text-sm text-white bg-green rounded-lg border border-green" role="alert">
              <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
          @endif
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                <div class="relative overflow-x-auto">
                  <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                      <thead class="text-gray-400 uppercase">
                          <tr>
                              <th scope="col" class="px-6 py-4">
                                {{ __('Plan Name') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('Price') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('Allowed RasberryPi') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('Is Discounted') }}
                              </th>                              
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('Actions') }}
                            </th>
                          </tr>
                      </thead>
                      <tbody>
                        @if(isset($plans) && count($plans) > 0)
                          @foreach($plans as $plan)
                            <tr class="bg-white border-b">
                                                    
                              <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                {{ $plan->plan_name }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                  €{{ number_format($plan->price, 2) }}
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                  {{ $plan->allowed_rasberry }}
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                  {{ $plan->isDiscount ? "Yes" : "No" }}
                                </td>                                
                                <td class="flex items-center justify-center px-6 py-4">
                                  <a href="{{ route('subscription-plans.edit', ['id' => $plan->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                  <a href="{{ route('subscription-plans.delete', ['id' => $plan->id]) }}" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Remove</a>
                              </td>
                            </tr>                          
                            @endforeach
                          @else
                            <tr>
                              <td colspan="5">
                                <p class="text-center">No Record(s) available.</p>
                              </td>
                            </tr>
                          @endif
                      </tbody>
                  </table>
                </div>

                
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
