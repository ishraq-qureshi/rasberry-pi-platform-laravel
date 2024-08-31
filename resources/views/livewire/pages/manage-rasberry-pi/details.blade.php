@inject('carbon', 'Carbon\Carbon')

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $rasberryPi->pi_name }} Details
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto flex flex-col gap-5 sm:px-6 lg:px-8">
          <div class="overflow-hidden flex gap-2">
            <div class="block flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
              <p class="font-normal text-sm text-gray-700 dark:text-gray-400">CPU Usage</p>
              <h5 class="mb-2 text-5xl font-bold tracking-tight text-gray-900">{{ $rasberryPi->analytics ? $rasberryPi->analytics->cpu_usage : "N/A" }}</h5>
            </div>
            <div class="block flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
              <p class="font-normal text-sm text-gray-700 dark:text-gray-400">RAM Usage</p>
              <h5 class="mb-2 text-5xl font-bold tracking-tight text-gray-900">{{ $rasberryPi->analytics ? $rasberryPi->analytics->ram_usage : "N/A" }}</h5>
            </div>
            <div class="block flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
              <p class="font-normal text-sm text-gray-700 dark:text-gray-400">Temperature</p>
              <h5 class="mb-2 text-5xl font-bold tracking-tight text-gray-900">{{ $rasberryPi->analytics ? $rasberryPi->analytics->temperature : "N/A" }}</h5>
            </div>
            <div class="block flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
              <p class="font-normal text-sm text-gray-700 dark:text-gray-400">Storage Usage</p>
              <h5 class="mb-2 text-5xl font-bold tracking-tight text-gray-900">{{ $rasberryPi->analytics ? $rasberryPi->analytics->storage_usage : "N/A" }}</h5>
            </div>
          </div>

          <div class="flex gap-4 items-start">
            <div class="bg-white flex-1 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6">
                  <h3 class="font-bold text-2xl">Notifications</h3>
                  <div class="flex flex-col">
                    @if(count($rasberryPi->notifications) > 0)
                      @foreach($rasberryPi->notifications as $notification)
                        <div class="flex gap-4 items-center border-b border-gray-200 p-4 py-6 last:border-0 last:pb-0">
                          @php
                            switch($notification->status):
                              case "warning":
                                $iconClass = "bg-yellow-100";
                                $label = "Warning";
                                break;
                              case "danger":
                                $iconClass = "bg-red-100";
                                $label = "Danger";
                                break;
                              case "ideal":
                                $iconClass = "bg-gray-100";
                                $label = "Idel";
                                break;
                            endswitch;

                            switch($notification->type):
                              case "cpu":
                                $message = "Your device CPU usage has reached $notification->value%";
                                break;
                              case "temperature":
                                $message = "Your device Temperature has reached $notification->value C";
                                break;
                              case "storage":
                                $message = "Your device Storage usage has reached $notification->value%";
                                break;
                              case "ram":
                                $message = "Your device RAM usage has reached $notification->value%";
                                break;
                            endswitch;
                          @endphp
                          <div class="flex w-14 h-14 flex justify-center items-center {{ $iconClass }} rounded-full ">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 50 50">
                              <path fill="#000000" d="M 25 0 C 22.800781 0 21 1.800781 21 4 C 21 4.515625 21.101563 5.015625 21.28125 5.46875 C 15.65625 6.929688 12 11.816406 12 18 C 12 25.832031 10.078125 29.398438 8.25 31.40625 C 7.335938 32.410156 6.433594 33.019531 5.65625 33.59375 C 5.265625 33.878906 4.910156 34.164063 4.59375 34.53125 C 4.277344 34.898438 4 35.421875 4 36 C 4 37.375 4.84375 38.542969 6.03125 39.3125 C 7.21875 40.082031 8.777344 40.578125 10.65625 40.96875 C 13.09375 41.472656 16.101563 41.738281 19.40625 41.875 C 19.15625 42.539063 19 43.253906 19 44 C 19 47.300781 21.699219 50 25 50 C 28.300781 50 31 47.300781 31 44 C 31 43.25 30.847656 42.535156 30.59375 41.875 C 33.898438 41.738281 36.90625 41.472656 39.34375 40.96875 C 41.222656 40.578125 42.78125 40.082031 43.96875 39.3125 C 45.15625 38.542969 46 37.375 46 36 C 46 35.421875 45.722656 34.898438 45.40625 34.53125 C 45.089844 34.164063 44.734375 33.878906 44.34375 33.59375 C 43.566406 33.019531 42.664063 32.410156 41.75 31.40625 C 39.921875 29.398438 38 25.832031 38 18 C 38 11.820313 34.335938 6.9375 28.71875 5.46875 C 28.898438 5.015625 29 4.515625 29 4 C 29 1.800781 27.199219 0 25 0 Z M 25 2 C 26.117188 2 27 2.882813 27 4 C 27 5.117188 26.117188 6 25 6 C 23.882813 6 23 5.117188 23 4 C 23 2.882813 23.882813 2 25 2 Z M 27.34375 7.1875 C 32.675781 8.136719 36 12.257813 36 18 C 36 26.167969 38.078125 30.363281 40.25 32.75 C 41.335938 33.941406 42.433594 34.6875 43.15625 35.21875 C 43.515625 35.484375 43.785156 35.707031 43.90625 35.84375 C 44.027344 35.980469 44 35.96875 44 36 C 44 36.625 43.710938 37.082031 42.875 37.625 C 42.039063 38.167969 40.679688 38.671875 38.9375 39.03125 C 35.453125 39.753906 30.492188 40 25 40 C 19.507813 40 14.546875 39.753906 11.0625 39.03125 C 9.320313 38.671875 7.960938 38.167969 7.125 37.625 C 6.289063 37.082031 6 36.625 6 36 C 6 35.96875 5.972656 35.980469 6.09375 35.84375 C 6.214844 35.707031 6.484375 35.484375 6.84375 35.21875 C 7.566406 34.6875 8.664063 33.941406 9.75 32.75 C 11.921875 30.363281 14 26.167969 14 18 C 14 12.261719 17.328125 8.171875 22.65625 7.21875 C 23.320313 7.707031 24.121094 8 25 8 C 25.886719 8 26.679688 7.683594 27.34375 7.1875 Z M 21.5625 41.9375 C 22.683594 41.960938 23.824219 42 25 42 C 26.175781 42 27.316406 41.960938 28.4375 41.9375 C 28.792969 42.539063 29 43.25 29 44 C 29 46.222656 27.222656 48 25 48 C 22.777344 48 21 46.222656 21 44 C 21 43.242188 21.199219 42.539063 21.5625 41.9375 Z"></path>
                            </svg>
                          </div>
                          <div class="flex-1">
                            <h5 class=" text-sm text-gray-400">{{ $label }}</h5>
                            <p class="text-md">{{ $message }}</p>
                            <p class="text-xs text-gray-400 italic">{{ $carbon::parse($notification->updated_at)->diffForHumans() }}</p>
                          </div>
                        </div>
                      @endforeach
                    @else
                        <p>No notifications available</p>
                    @endif
                  </div>
              </div>
            </div>

            <div class="bg-white flex-1 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                <ul class="flex flex-col gap-4">
                  <li class="flex gap-2 justify-between items-center">
                    <span class="font-bold">Serial Number:</span>
                    <span>{{ $rasberryPi->analytics ? $rasberryPi->analytics->serial_number : "N/A" }}</span>
                  </li>
                  <li class="flex gap-2 justify-between items-center">
                    <span class="font-bold">Modal:</span>
                    <span>{{ $rasberryPi->analytics ? $rasberryPi->analytics->model : "N/A" }}</span>
                  </li>
                  <li class="flex gap-2 justify-between items-center">
                    <span class="font-bold">IP Address Lan:</span>
                    <span>{{ $rasberryPi->analytics ? $rasberryPi->analytics->ip_address_lan	: "N/A" }}</span>
                  </li>
                  <li class="flex gap-2 justify-between items-center">
                    <span class="font-bold">IP Address WAN:</span>
                    <span>{{ $rasberryPi->analytics ? $rasberryPi->analytics->ip_address_wlan : "N/A" }}</span>
                  </li>
                  <li class="flex gap-2 justify-between items-center">
                    <span class="font-bold">Last Updated:</span>
                    <span>{{ $rasberryPi->analytics ? $carbon::parse($rasberryPi->analytics->updated_at)->diffForHumans() : "N/A" }}</span>
                  </li>

                </ul>
              </div>
            </div>

          </div>
      </div>
  </div>
</x-app-layout>
