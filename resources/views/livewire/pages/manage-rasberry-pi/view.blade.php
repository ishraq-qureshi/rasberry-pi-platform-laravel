<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Manage Rasberry Pi') }}
        </h2>
        <a href="{{ route('rasberry-pi.create') }}" class="py-2 px-6 bg-black text-white rounded-md">Add New Rasberry Pi</a>        
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">        
          @if(session('success'))
            <div class="p-4 mb-4 text-sm text-white bg-green rounded-lg border border-green" role="alert">
              <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
          @endif
          @if(session('error'))
            <div class="p-4 mb-4 text-sm text-white bg-red-600 rounded-lg border border-red-600" role="alert">
              <span class="font-medium">Error!</span> {{ session('error') }}
            </div>
          @endif
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                <div class="relative overflow-x-auto">
                  <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                      <thead class="text-gray-400 uppercase">
                          <tr>
                              <th scope="col" class="px-6 py-4">
                                {{ __('Name') }}
                              </th>
                              <th scope="col" class="px-6 py-4 text-center">
                                {{ __('Model') }}
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
                        @if(isset($rasberryPis) && count($rasberryPis) > 0)
                          @foreach($rasberryPis as $rasberryPi)
                            <tr class="bg-white border-b">
                                                    
                              <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                {{ $rasberryPi->pi_name }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                  {{ $rasberryPi->model->model_name }}
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                  <span class="w-2 h-2 inline-block {{ $rasberryPi->isOnline() ? 'bg-green' : 'bg-red-600' }} rounded-full"></span> {{ $rasberryPi->isOnline() ? "Online" : "Offline"}}                                  
                                </td>
                                <td class="flex items-center justify-center px-6 py-4">
                                  <a href="{{ route('rasberry-pi.edit', ['id' => $rasberryPi->id]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                  <a href="{{ route('rasberry-pi.delete', ['id' => $rasberryPi->id]) }}" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Remove</a>
                                  <a href="{{ route('rasberry-pi.connect', ['id' => $rasberryPi->id]) }}" class="font-medium text-gray-600 dark:text-gray-500 hover:underline ms-3">Connect</a>
                                  <a href="{{ route('rasberry-pi.details', ['id' => $rasberryPi->id]) }}" class="font-medium text-black hover:underline ms-3">View</a>
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
