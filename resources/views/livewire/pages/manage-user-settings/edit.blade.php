<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('messages.manage_settings') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
              <div class="p-6 text-gray-900">

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
                  
                <form class="" method="post" action="{{ route('user-setting.save') }}">
                  @csrf
                  <div class="mb-4">
                    <label for="cpu_notification" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.cpu_notification") }}</label>
                    <select id="cpu_notification" name="cpu_notification" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 py-4">
                      <option value="ideal" {{ $data['cpu_notification'] === 'ideal' ? 'selected' : "" }}>{{ __("messages.ideal") }}</option>
                      <option value="warning" {{ $data['cpu_notification'] === 'warning' ? 'selected' : "" }}>{{ __("messages.warning") }}</option>
                      <option value="danger" {{ $data['cpu_notification'] === 'danger' ? 'selected' : "" }}>{{ __("messages.danger") }}</option>
                      <option value="no_notification" {{ $data['cpu_notification'] === 'no_notification' ? 'selected' : "" }}>{{ __("messages.turn_off_notification") }}</option>
                    </select>
                    @error('cpu_notification')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="ram_notification" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.ram_notification") }}</label>
                    <select id="ram_notification" name="ram_notification" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 py-4">
                      <option value="ideal" {{ $data['ram_notification'] === 'ideal' ? 'selected' : "" }}>{{ __("messages.ideal") }}</option>
                      <option value="warning" {{ $data['ram_notification'] === 'warning' ? 'selected' : "" }}>{{ __("messages.warning") }}</option>
                      <option value="danger" {{ $data['ram_notification'] === 'danger' ? 'selected' : "" }}>{{ __("messages.danger") }}</option>
                      <option value="no_notification" {{ $data['ram_notification'] === 'no_notification' ? 'selected' : "" }}>{{ __("messages.turn_off_notification") }}</option>                      
                    </select>
                    @error('ram_notification')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="storage_notification" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.storage_notification") }}</label>
                    <select id="storage_notification" name="storage_notification" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 py-4">
                      <option value="ideal" {{ $data['storage_notification'] === 'ideal' ? 'selected' : "" }}>{{ __("messages.ideal") }}</option>
                      <option value="warning" {{ $data['storage_notification'] === 'warning' ? 'selected' : "" }}>{{ __("messages.warning") }}</option>
                      <option value="danger" {{ $data['storage_notification'] === 'danger' ? 'selected' : "" }}>{{ __("messages.danger") }}</option>
                      <option value="no_notification" {{ $data['storage_notification'] === 'no_notification' ? 'selected' : "" }}>{{ __("messages.turn_off_notification") }}</option>
                    </select>
                    @error('storage_notification')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="temperature_notification" class="block mb-2 text-sm font-medium text-gray-900">{{ __("messages.temperature_notification") }}</label>
                    <select id="temperature_notification" name="temperature_notification" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 py-4">
                      <option value="ideal" {{ $data['temperature_notification'] === 'ideal' ? 'selected' : "" }}>{{ __("messages.ideal") }}</option>
                      <option value="warning" {{ $data['temperature_notification'] === 'warning' ? 'selected' : "" }}>{{ __("messages.warning") }}</option>
                      <option value="danger" {{ $data['temperature_notification'] === 'danger' ? 'selected' : "" }}>{{ __("messages.danger") }}</option>
                      <option value="no_notification" {{ $data['temperature_notification'] === 'no_notification' ? 'selected' : "" }}>{{ __("messages.turn_off_notification") }}</option>
                    </select>
                    @error('temperature_notification')
                        <div class="text-red-600 text-xs">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="flex justify-end gap-4 mt-8">
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
