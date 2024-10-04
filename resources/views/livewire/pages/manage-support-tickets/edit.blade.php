<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('messages.manage_my_tickets') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  
                <form class="" method="post" action="{{ route('user-tickets.save') }}">
                  @csrf
                  <div class="mb-4">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.title") }}</label>
                    <input type="text" name="title" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4" placeholder="Enter title" value="{{ isset($supportTicket) ? $supportTicket->title : "" }}" />
                    @error('title')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.message") }}</label>
                    <textarea name="message" class="border border-gray-400 text-sm rounded-md block w-full px-2 py-4 h-96 resize-none"></textarea>
                    @error('message')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="flex justify-end gap-4 mt-8">
                    @isset($supportTicket)
                      <input type="hidden" name="id" value="{{ $supportTicket->id }}" />
                    @endisset
                    <a href="{{ route('rasberry-pi.view') }}" class="py-2 px-6 bg-red-500 text-white rounded-md">
                      {{ __("messages.back") }}
                    </a>
                    <button type="submit" class='class="py-2 px-6 bg-black text-white rounded-md'>
                      {{ __("messages.save") }}
                    </button>
                  
                  </div>                  
                </form>

              </div>
          </div>
      </div>
  </div>
</x-app-layout>
