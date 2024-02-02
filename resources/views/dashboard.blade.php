<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="pt-6">
        <div class="grid grid-cols-12">
            <div class="sm:px-6 lg:px-8 lg:col-span-8 sm:col-span-12">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
            <div class="sm:col-span-12 lg:col-span-4">
                <div class="grid grid-cols-12 sm:pt-3 lg:pt-0">
                    <div class="sm:px-6 col-span-12 lg:px-8 pb-3">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-300">
                            <div class="p-6 text-center sm:mt-0 sm:ml-2 sm:text-left">
                                <h3 class="text-sm leading-6 font-medium text-gray-400">Total Locomotif</h3>
                                <p class="text-3xl font-bold text-black">{{ $summary->sum('total') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="sm:px-6 col-span-12 lg:px-8 pb-3">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-300">
                            <div class="p-6 text-center sm:mt-0 sm:ml-2 sm:text-left">
                                <h3 class="text-sm leading-6 font-medium text-gray-400">Total Locomotif Active</h3>
                                <p class="text-3xl font-bold text-black">{{ $summary->where('status', 1)->sum('total') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="sm:px-6 col-span-12 lg:px-8 pb-3">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-300">
                            <div class="p-6 text-center sm:mt-0 sm:ml-2 sm:text-left">
                                <h3 class="text-sm leading-6 font-medium text-gray-400">Total Locomotif Non Active</h3>
                                <p class="text-3xl font-bold text-black">{{ $summary->where('status', 0)->sum('total') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var xAxis = @json($xAxis);
    var yAxisActive = @json($yAxisActive);
    var yAxisNonActive = @json($yAxisNonActive);
    var options = {
        chart: {
            type: 'bar'
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            dataLabels: {
              position: 'top',
            },
          }
        },
        series: [{
            name: 'ACTIVE',
            data: yAxisActive
        },{
            name: 'NON ACTIVE',
            data: yAxisNonActive
        }],
        dataLabels: {
            enabled: true,
            offsetX: -6,
            style: {
                fontSize: '24px',
                colors: ['#fff']
            }
        },
        xaxis: {
            categories: xAxis
        },
        stroke: {
          width: 2,
          colors: ['#fff']
        },
        title: {
            text: 'Summary Report Locomotif'
        }
    }

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();
</script>
