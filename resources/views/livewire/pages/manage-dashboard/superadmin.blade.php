<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="flex flex-col gap-4">
            <div class="flex flex-wrap">
              <div class="overflow-hidden flex gap-4 w-full">
                <div class="block flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                  <p class="font-normal text-sm text-gray-700 dark:text-gray-400">Total Users</p>
                  <h5 class="mb-2 text-5xl font-bold tracking-tight text-gray-900">{{ $data["totalUsersCount"] }}</h5>
                </div>
                <div class="block flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                  <p class="font-normal text-sm text-gray-700 dark:text-gray-400">Revenue (Weekly)</p>
                  <h5 class="mb-2 text-5xl font-bold tracking-tight text-gray-900">€{{ number_format($data["totalRevenueWeek"], 2) }}</h5>
                </div>
                <div class="block flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                  <p class="font-normal text-sm text-gray-700 dark:text-gray-400">Revenue (Monthly)</p>
                  <h5 class="mb-2 text-5xl font-bold tracking-tight text-gray-900">€{{ number_format($data["totalRevenueMonth"], 2) }}</h5>
                </div>
                <div class="block flex-1 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                  <p class="font-normal text-sm text-gray-700 dark:text-gray-400">Active Subscriptions</p>
                  <h5 class="mb-2 text-5xl font-bold tracking-tight text-gray-900">{{ $data["totalSubscriptions"] }}</h5>
                </div>
              </div>
            </div>
  
            <div class="bg-white w-full overflow-hidden shadow-sm sm:rounded-lg">
              <div class="w-full bg-white rounded-lg shadow p-4 md:p-6">
                <div class="flex justify-between mb-5">
                  <div class="flex flex-1 items-center justify-between">
                    <div>
                      <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">Last 6 Months Revenue</h5>
                    </div>                    
                  </div>                  
                </div>
                <div id="monthly-revenue-chart"></div>
              </div>
            </div>

            <div class="flex gap-4">              
                <div class="bg-white flex-1 overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 text-gray-900">
                    <h2>Users</h2>
                    <div class="relative overflow-x-auto">
                      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          <thead class="text-gray-400 uppercase">
                              <tr>
                                  <th scope="col" class="px-6 py-4">
                                    {{ __('Full Name') }}
                                  </th>
                                  <th scope="col" class="px-6 py-4 text-center">
                                    {{ __('Rasberry Pis') }}
                                  </th>
                                  <th scope="col" class="px-6 py-4 text-center">
                                    {{ __('Sub Admins') }}
                                  </th>
                                  <th scope="col" class="px-6 py-4 text-center">
                                    {{ __('Plans') }}
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                            @if(isset($data["users"]) && count($data["users"]) > 0)
                              @foreach($data["users"] as $user)
                                <tr class="bg-white border-b">
                                  
                                    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                    {{ $user->name }}
                                    </th>
                                    <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                      {{ count($user->raspberryPis) }}
                                    </td>                          
                                    <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                      {{ count($user->subUsers) }}
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
                                      {{ isset($user->subscriptions) && count($user->subscriptions) > 0 ? $user->subscriptions[0]->plan->plan_name : "No Active Subscription" }}
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
      </div>
  </div>


  <script>

    var monthlyRevenue = JSON.parse({!! json_encode($data["revenuePerMonth"]) !!})
    var getMonthlyRevenueChartOptions = {
      chart: {
        height: "100%",
        maxWidth: "100%",
        type: "line",
        fontFamily: "Inter, sans-serif",
        dropShadow: {
          enabled: false,
        },
        toolbar: {
          show: false,
        },
      },
      tooltip: {
        enabled: true,
        x: {
          show: false,
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        width: 6,
      },
      grid: {
        show: true,
        strokeDashArray: 4,
        padding: {
          left: 2,
          right: 2,
          top: -26
        },
      },
      series: [
        {
          name: "Revenue",
          data: monthlyRevenue.values,
          color: "#1A56DB",
        }
      ],
      legend: {
        show: true
      },
      stroke: {
        curve: 'smooth'
      },
      xaxis: {
        categories: monthlyRevenue.labels,
        labels: {
          show: true,
          style: {
            fontFamily: "Inter, sans-serif",
            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
          }
        },
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
      },
      yaxis: {
        show: true,
        labels: {
        formatter: function (value) {
          return '€' + value.toFixed(2);
        }
      }
      },
    }
    if (document.getElementById("monthly-revenue-chart") && typeof ApexCharts !== 'undefined') {
      const chart = new ApexCharts(document.getElementById("monthly-revenue-chart"), getMonthlyRevenueChartOptions);
      chart.render();      
    }
  </script>
</x-app-layout>
