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
            <div class="bg-white flex-1 w-full overflow-hidden shadow-sm sm:rounded-lg">
              <div class="w-full bg-white rounded-lg shadow p-4 md:p-6">                
                <div id="tota-storage-chart"></div>   
              </div>
            </div>
            {{-- TOTAL STORAGE USAGE --}}
            
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
          height: 275,
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
