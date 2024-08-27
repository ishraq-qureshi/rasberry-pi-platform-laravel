<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Confirm Delete') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  <form method="post" action="{{ route('subscription-plans.destroy', ['id' => $plan->id]) }}">
                      @method('delete')
                      @csrf
                      <p class="text-lg">{{ __("Are you sure want to delete?") }} <span class="font-bold">{{ $plan->plan_name }}</span></p>
                      <div class="mt-4 flex gap-3">
                        <a href="{{ route('subscription-plans.view') }}" class='inline-flex items-center px-3 text-sm py-1 bg-red-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'>
                          Back
                        </a>
                        <button type="submit" class='inline-flex items-center px-3 text-sm py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'>
                          Delete
                        </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
