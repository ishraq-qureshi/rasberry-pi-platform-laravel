<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('messages.manage_users') }}
        </h2>
        @hasanyrole("admin|superadmin")
          <a href="{{ route('users.create') }}" class="py-2 px-6 bg-black text-white rounded-md">{{ __("messages.add_new_user") }}</a>
        @endrole
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">        
          @if(session('success'))
            <div class="p-4 mb-4 text-sm text-white bg-green rounded-lg border border-green" role="alert">
              <span class="font-medium">{{ __("messages.success") }}!</span> {{ session('success') }}
            </div>
          @endif
          @if(session('error'))
            <div class="p-4 mb-4 text-sm text-white bg-red-600 rounded-lg border border-red-600" role="alert">
              <span class="font-medium">{{ __("messages.error") }}!</span> {{ session('error') }}
            </div>
          @endif
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                <div class="relative overflow-x-auto">
                  <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                      <thead class="text-gray-400 uppercase">
                          <tr>
                              <th scope="col" class="px-6 py-4">
                                {{ __('messages.full_name') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('messages.email') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('messages.subscription_plan') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('messages.status') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('messages.action') }}
                            </th>
                          </tr>
                      </thead>
                      <tbody>
                        @if(isset($users) && count($users) > 0)
                          @foreach($users as $user)
                            <tr class="bg-white border-b">
                                @role('superadmin')
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                {{ $user->name }}
                                </th>
                                <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                  {{ $user->email }}
                                </td>                                
                                <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                  {{ $user->subscriptions && count($user->subscriptions) > 0 ? $user->subscriptions[0]->plan->plan_name : __("messages.no_plan_selected") }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center capitalize">
                                  {{ $user->subscriptions && count($user->subscriptions) > 0 ? $user->subscriptions[0]->status : "Pending" }}
                                </td>
                                <td class="flex items-center justify-center px-6 py-4">
                                  <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __("messages.edit") }}</a>
                                  <a href="{{ route('users.delete', ['id' => $user->id]) }}" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">{{ __("messages.remove") }}</a>
                              </td>
                                @endrole
                                @role('admin')
                                  <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                  {{ $user->user->name }}
                                  </th>
                                  <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                    {{ $user->user->email }}
                                  </td>       
                                  <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                    {{ $user->parentUser->subscriptions && count($user->parentUser->subscriptions) > 0 ? $user->parentUser->subscriptions[0]->plan->plan_name : __("messages.no_plan_selected") }}
                                  </td>
                                  <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center capitalize">
                                    {{ $user->parentUser->subscriptions && count($user->parentUser->subscriptions) > 0 ? $user->parentUser->subscriptions[0]->status : "Pending" }}
                                  </td>
                                  <td class="flex items-center justify-center px-6 py-4">
                                    <a href="{{ route('users.edit', ['id' => $user->user->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __("messages.edit") }}</a>
                                    <a href="{{ route('users.delete', ['id' => $user->user->id]) }}" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">{{ __("messages.remove") }}</a>
                                  </td>
                                @endrole
                                
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
                </div>

                
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
