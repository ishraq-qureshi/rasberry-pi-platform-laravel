<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('messages.manage_my_tickets') }}
        </h2>
        @role("admin")
        <a href="{{ route('user-tickets.create') }}" class="py-2 px-6 bg-black text-white rounded-md">{{ __("messages.add_support_ticket") }}</a>        
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
                                {{ __('messages.name') }}
                              </th>                    
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('messages.action') }}
                            </th>
                          </tr>
                      </thead>
                      <tbody>
                        @if(isset($supportTickets) && count($supportTickets) > 0)
                          @foreach($supportTickets as $tickets)
                            <tr class="bg-white border-b">                                              
                              <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                {{ $tickets->title }}
                              </th>                                
                              <td class="flex items-center justify-center px-6 py-4">
                                <a href="{{ route('user-tickets.details', ['id' => $tickets->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __("messages.view") }}</a>                                
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
                </div>

                
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
