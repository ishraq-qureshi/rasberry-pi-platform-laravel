<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Manage Subscription Plans') }}
        </h2>
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
                                {{ __('Full Name') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('Email') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('Subscription Plan') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('Status') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('Actions') }}
                            </th>
                          </tr>
                      </thead>
                      <tbody>
                        @if(isset($users) && count($users) > 0)
                          @foreach($users as $user)
                            <tr class="bg-white border-b">
                                                    
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                {{ $user->name }}
                                </th>
                                <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                  {{ $user->email }}
                                </td>                                
                                <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                  {{ $user->subscriptions && count($user->subscriptions) > 0 ? $user->subscriptions[0]->plan->plan_name : "No Plan Selected" }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center capitalize">
                                  {{ $user->subscriptions && count($user->subscriptions) > 0 ? $user->subscriptions[0]->status : "Pending" }}
                                </td>
                                <td class="flex items-center justify-center px-6 py-4">
                                  <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                  <a href="{{ route('users.delete', ['id' => $user->id]) }}" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Remove</a>
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
