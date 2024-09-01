@inject('carbon', 'Carbon\Carbon')

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="flex flex-wrap gap-4 items-start">
            {{-- TOTAL DEVICES  --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">                
                <div class="w-full bg-white rounded-lg shadow ">    
                    <!-- Donut Chart -->
                    <div class="py-6" id="top-devices-chart"></div>          
                </div>
            </div>
            {{-- TOTAL DEVICES --}}

            {{-- TOTAL STORAGE USAGE --}}
            <div class="bg-white w-[calc(100%-316px)] overflow-hidden shadow-sm sm:rounded-lg">
              <div class="w-full bg-white rounded-lg shadow p-4 md:p-6">       
                <div class="flex flex-col justify-between mb-5">
                  <div>
                    <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">Total Storages</h5>
                  </div>
                  <div id="tota-storage-chart"></div>                   
                </div>         
              </div>
            </div>
            {{-- TOTAL STORAGE USAGE --}}

            <div class="flex gap-4 w-full">
              {{-- ALL NOTIFICATIONS --}}
              <div class="bg-white w-[calc(100%/2-8px)] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full bg-white rounded-lg shadow p-4 md:p-6">
                  <div class="flex justify-between">
                    <div class="flex flex-1 items-center justify-between">
                      <div>
                        <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">Notifications</h5>
                      </div>                          
                    </div>                  
                  </div>
                  <div class="flex flex-col">
                    @if(count($data["notifications"]) > 0)
                      @foreach($data["notifications"] as $notification)
                        <div class="flex gap-4 items-center border-b border-gray-200 p-4 py-6 last:border-0 last:pb-0">
                          @php
                            switch($notification['status']):
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
                            
                            $value = $notification["value"];

                            $deviceName = $notification["rasberry_pi"]["pi_name"];
                            
                            switch($notification['type']):
                              case "cpu":
                                $message = "The $deviceName CPU usage has reached $value%";
                                break;
                              case "temperature":
                                $message = "The $deviceName Temperature has reached $value C";
                                break;
                              case "storage":
                                $message = "The $deviceName Storage usage has reached $value%";
                                break;
                              case "ram":
                                $message = "The $deviceName RAM usage has reached $value%";
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
                            <p class="text-xs text-gray-400 italic">{{ $carbon::parse($notification['updated_at'])->diffForHumans() }}</p>
                          </div>
                        </div>
                      @endforeach
                    @else
                        <p>No notifications available</p>
                    @endif
                  </div>
                </div>
              </div>
              {{-- ALL NOTIFICATIONS --}}

              <div class="flex w-[calc(100%/2-8px)] flex-col gap-4">
                {{-- TOTAL CPU USAGE --}}
                <div class="bg-white w-full overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="w-full bg-white rounded-lg shadow p-4 md:p-6">
                    <div class="flex justify-between mb-5">
                      <div class="flex flex-1 items-center justify-between">
                        <div>
                          <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">Total CPU Usage</h5>
                        </div>      
                        <div>
                          <select id="cpuInterval">
                            <option value="24">Last 24 Hours</option>
                            <option value="3">Last 3 Hours</option>
                            <option value="1">Last 1 Hours</option>
                          </select>
                        </div>
                      </div>                  
                    </div>
                    <div id="top-cpu-usage-chart"></div>
                  </div>
                </div>
                {{-- TOTAL CPU USAGE --}}

                {{-- TOTAL RAM USAGE --}}
                <div class="bg-white w-full overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="w-full bg-white rounded-lg shadow p-4 md:p-6">
                    <div class="flex justify-between mb-5">
                      <div class="flex flex-1 items-center justify-between">
                        <div>
                          <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">Total RAM Usage</h5>
                        </div>      
                        <div>
                          <select id="ramInterval">
                            <option value="24">Last 24 Hours</option>
                            <option value="3">Last 3 Hours</option>
                            <option value="1">Last 1 Hours</option>
                          </select>
                        </div>
                      </div>                  
                    </div>
                    <div id="ram-usage-chart"></div>
                  </div>
                </div>
                {{-- TOTAL RAM USAGE --}} 
              </div>
            </div>                                             
          </div>
      </div>
  </div>


  <script>

      const getTotalDevicesChartOptions = () => {
          return {
              series: [{{ $data["totalDevices"]["online"] }}, {{ $data["totalDevices"]["offline"] }}],
              colors: ["#1C64F2", "#D22B2B",],
              chart: {
                  height: 320,
                  width: "100%",
                  type: "donut",
              },
              stroke: {
                  colors: ["transparent"],
                  lineCap: "",
              },
              plotOptions: {
                  pie: {
                      donut: {
                          labels: {
                              show: true,
                              name: {
                                  show: true,
                                  fontFamily: "Inter, sans-serif",
                                  offsetY: 20,
                              },
                              total: {
                                  showAlways: true,
                                  show: true,
                                  label: "Total Devices",
                                  fontFamily: "Inter, sans-serif",
                                  formatter: function (w) {
                                      const sum = w.globals.seriesTotals.reduce((a, b) => {
                                          return a + b
                                      }, 0)
                                      return sum
                                  },
                              },
                              value: {
                                  show: true,
                                  fontFamily: "Inter, sans-serif",
                                  offsetY: -20,
                                  formatter: function (value) {
                                      return value + "device(s)"
                                  },
                              },
                          },
                          size: "80%",
                      },
                  },
              },
              grid: {
                  padding: {
                      top: -2,
                  },
              },
              labels: ["Online", "Offline"],
              dataLabels: {
                  enabled: false,
              },
              legend: {
                  position: "bottom",
                  fontFamily: "Inter, sans-serif",
              },
              yaxis: {
                  labels: {
                      formatter: function (value) {
                          return value + " device(s)"
                      },
                  },
              },
              xaxis: {
                  labels: {
                      formatter: function (value) {
                          return value  + " device(s)"
                      },
                  },
                  axisTicks: {
                      show: false,
                  },
                  axisBorder: {
                      show: false,
                  },
              },
          }
      }
      
      if (document.getElementById("top-devices-chart") && typeof ApexCharts !== 'undefined') {
          const chart = new ApexCharts(document.getElementById("top-devices-chart"), getTotalDevicesChartOptions());
          chart.render(); 
      }

      const cpuJSONData = JSON.parse({!! json_encode($data["cpuUsage"]) !!});

      const getCpuUsageChartOptions = {
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
        series: cpuJSONData,
        legend: {
          show: true
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
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
        },
      }
      if (document.getElementById("top-cpu-usage-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("top-cpu-usage-chart"), getCpuUsageChartOptions);
        chart.render();

        jQuery("#cpuInterval").change(function() {
          const interval = jQuery(this).val();
          
          jQuery.ajax({
              url: "{{ route('dashboard.getCpuUsage', ':hours') }}".replace(':hours', interval),
              type: "GET",
              success: function(data) {
                  if(data.success) {
                    const newData = JSON.parse(data.data);
                    chart.updateSeries(newData) 
                  }
                  // Handle the received data (e.g., update your chart)
              },
              error: function(xhr, status, error) {
                  console.error("An error occurred: " + error);
              }
          });
        });
      }

      const getRamUsageChartOptions = {
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
        series: JSON.parse({!! json_encode($data["ramUsage"]) !!}),
        legend: {
          show: true
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
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
        },
      }
      if (document.getElementById("ram-usage-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("ram-usage-chart"), getRamUsageChartOptions);
        chart.render();

        jQuery("#ramInterval").change(function() {
          const interval = jQuery(this).val();
          
          jQuery.ajax({
              url: "{{ route('dashboard.getRamUsage', ':hours') }}".replace(':hours', interval),
              type: "GET",
              success: function(data) {
                  if(data.success) {
                    const newData = JSON.parse(data.data);
                    chart.updateSeries(newData) 
                  }
                  // Handle the received data (e.g., update your chart)
              },
              error: function(xhr, status, error) {
                  console.error("An error occurred: " + error);
              }
          });
        });
      }


      const storageUsageData = JSON.parse({!! json_encode($data["storageUsage"]) !!});

      const totalStorageChartOptions = {
        series: storageUsageData.series,
        chart: {
          sparkline: {
            enabled: false,
          },
          type: "bar",
          width: "100%",
          height: 225,
          toolbar: {
            show: false,
          }
        },
        fill: {
          opacity: 1,
        },
        plotOptions: {
          bar: {
            horizontal: true,
            columnWidth: "100%",
            borderRadiusApplication: "end",
            borderRadius: 6,
            dataLabels: {
              position: "top",
            },
          },
        },
        legend: {
          show: true,
          position: "bottom",
        },
        dataLabels: {
          enabled: false,
        },
        tooltip: {
          shared: true,
          intersect: false,
          formatter: function (value) {
            return value + "%"
          }
        },
        xaxis: {
          labels: {
            show: true,
            style: {
              fontFamily: "Inter, sans-serif",
              cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            },
            formatter: function(value) {
              return value + "%"
            }
          },
          categories: storageUsageData.names,
          axisTicks: {
            show: false,
          },
          axisBorder: {
            show: false,
          },
        },
        yaxis: {
          labels: {
            show: true,
            style: {
              fontFamily: "Inter, sans-serif",
              cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            }
          }
        },
        grid: {
          show: true,
          strokeDashArray: 4,
          padding: {
            left: 2,
            right: 2,
            top: -20
          },
        },
        fill: {
          opacity: 1,
        }
      }

      if(document.getElementById("tota-storage-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("tota-storage-chart"), totalStorageChartOptions);
        chart.render();
      }

  </script>

</x-app-layout>
