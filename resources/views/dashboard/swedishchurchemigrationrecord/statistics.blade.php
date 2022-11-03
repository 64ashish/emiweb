<x-app-layout>

    @if(Str::is('scerc.generateChart', Route::currentRoutename()) == true)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
    @endif


    <!-- Main 3 column grid -->
{{--    @include('dashboard._breadcrumb')--}}
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section
                class="pt-6" aria-labelledby="section-1-title">
            <ul class="flex gap-x-5 justify-end mr-8 mb-[18px]">
                <li >
                    <a class="p-5 bg-indigo-600 text-white rounded-t-lg"

                       href="{{ route('scerc.statics') }}">
                        Statistik
                    </a>
                </li>

            </ul>
            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                @if(isset($keywords))
                    {!! Form::model($keywords,['route' => 'scerc.generateChart'])  !!}
                @endif
                @if(!isset($keywords))
                    {!! Form::open(['route' => 'scerc.generateChart'])  !!}
                @endif
                <div class="grid grid-cols-2 gap-4 pb-4">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="first_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Gender') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                           {!! Form::select('gender', ['All' => 'Alla', 'Män' => 'Män', 'Kvinnor' => 'Kvinnor'],null,['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'first_name']) !!}
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="first_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Record year') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            <div class="flex gap-2 items-center">
                                {!! Form::text("start_year", null,
                               ['class' => 'max-w-lg w-24 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                               sm:max-w-xs sm:text-sm border-gray-300 rounded-md','placeholder' => "YYYY"]) !!}
                                <span>-</span>
                                {!! Form::text("end_year", null,
                               ['class' => 'max-w-lg w-24 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                               sm:max-w-xs sm:text-sm border-gray-300 rounded-md','placeholder' => "YYYY"]) !!}

                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="from_province" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Basområde') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            {!! Form::select('from_province', $provinces,null,['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                             sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                             ]) !!}
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="group_by" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Gruppering') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            {!! Form::select('group_by', ['record_date' => __('Record year'), 'from_provinces' => __('Basområde')],null,['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                             sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                             ]) !!}
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="first_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Typ av digram') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            {!! Form::select('chart_type', ['bar' => 'Stapel', 'pie' => 'Cirkel'],null,['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                             sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                             'id' => 'first_name']) !!}
                        </div>
                    </div>



                </div>
                <div class="sm:flex justify-end pt-4 gap-x-5">
                    <button type="submit" name="action" value="filter" class=" inline-flex items-center px-8 py-2 border
                                            border-transparent text-base font-medium rounded-md shadow-sm text-white
                                            {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700 focus:outline-none focus:ring-2
                                            focus:ring-offset-2 focus:ring-indigo-500">{{ __('Search Statistics') }}</button>
                </div>
            </div>
            {!! Form::close() !!}

        </section>
    @if(Str::is('scerc.generateChart', Route::currentRoutename()) == true)
        <section
                 class="pt-6" aria-labelledby="section-1-title">



            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <div class="flex justify-end items-center pb-4">


                    <div onclick="capture()" class="inline-flex items-center rounded border border-transparent bg-indigo-600 px-2.5
                                    py-1.5 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none
                                     focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        <span>
                                {{ __('Download image') }}
                        </span>

                    </div>

                </div>


                <div id="captureThis">
                    <p class="text-left text-sm font-semibold text-gray-900">
                        {{ $title }}
                    </p>
{{--                    {{ $data }}--}}
                    <canvas id="myChart"></canvas>
                </div>




            </div>



        </section>
        @endif

    </div>

    @if(Str::is('scerc.generateChart', Route::currentRoutename()) == true)
    <script>


        var poolColors = function (a) {
            var pool = [];
            for(i=0;i<a;i++){
                pool.push(dynamicColors());
            }
            return pool;
        }

        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ", 0.4)";
        }

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: {{ Js::from($chart_type) }},
            data: {
                labels: {{ Js::from($data->pluck($grouped_by)) }},
                datasets: [{
                    label: {{ Js::from($title) }},
                    grouped:true,
                    maxBarThickness:'50',
                    data: {{ Js::from($data->pluck('total')) }},
                    backgroundColor: poolColors({{ Js::from($data->pluck('total')->count()) }}),

                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],

                    borderWidth: 0.5,
                    hoverOffset: 4
                }]
            },
            options: {

                indexAxis: 'y',
                responsive: true,




            }


        });



    </script>
        <script>
            function capture()
            {
                html2canvas(document.querySelector("#captureThis")).then(function(canvas) {
                    canvas.toBlob(function(blob) {
                        window.saveAs(blob, {{ Js::from($title) }}+'.jpg');
                    });
                });
            }
        </script>
    @endif


</x-app-layout>
