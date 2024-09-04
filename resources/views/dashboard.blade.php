<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">                
                    <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6">    
                        <!-- Donut Chart -->
                        <div class="py-6" id="donut-chart"></div>          
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
