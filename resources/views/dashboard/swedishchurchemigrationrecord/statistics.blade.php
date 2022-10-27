<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Main 3 column grid -->
{{--    @include('dashboard._breadcrumb')--}}
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section
                class="pt-6" aria-labelledby="section-1-title">
            <ul class="flex gap-x-5 justify-end mr-8 mb-[18px]">
                <li >
                    <a class="p-5 bg-emerald-600 text-white rounded-t-lg"c
                       href="{{ route('scerc.statics') }}">
                        Statistikå
                    </a>
                </li>
                <li >
                    <a class="p-5 bg-emerald-600 text-white rounded-t-lg" href="">
                        Sök dokument
                    </a>
                </li>
                <li >
                    <a class="p-5 bg-emerald-600 text-white rounded-t-lg" href="">
                        Sök fotografi
                    </a>
                </li>
                <li >
                    <a class="p-5 bg-emerald-600 text-white rounded-t-lg" href="">
                        Ny emigrant
                    </a>
                </li>
            </ul>
            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                {!! Form::open(['route' => 'scerc.generateChart'])  !!}
                <div class="grid grid-cols-2 gap-4 pb-4">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="first_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Gender') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                           {!! Form::select('gender', ['All' => 'Alla', 'M' => 'Män', 'K' => 'Kvinnor'],null,['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'first_name']) !!}
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="first_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Record year') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            <div class="flex gap-2">
                                {!! Form::text("start_year", null,
                               ['class' => 'max-w-lg w-24 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                               sm:max-w-xs sm:text-sm border-gray-300 rounded-md','placeholder' => "YYYY"]) !!}
                                {!! Form::text("end_year", null,
                               ['class' => 'max-w-lg w-24 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                               sm:max-w-xs sm:text-sm border-gray-300 rounded-md','placeholder' => "YYYY"]) !!}

                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="from_province" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('From province') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            {!! Form::select('from_province', $provinces,null,['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                             sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                             'id' => 'first_name']) !!}
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="group_by" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Gruppering') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            {!! Form::select('group_by', ['record_date' => 'Record date', 'from_provinces' => 'Provinces'],null,['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
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
        <section
                 class="pt-6" aria-labelledby="section-1-title">



            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                    {{ __('Search in') }}  Emigranter registrerade i svenska kyrkböcker
                </p>

                <div>
{{--                    {{ $data }}--}}
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>




            </div>



        </section>

    </div>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {{ Js::from($data->pluck($chart_type)) }},
                datasets: [{
                    label: 'Users per year',
                    grouped:true,
                    // barThickness:'10',
                    data: {{ Js::from($data->pluck('total')) }},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    hoverOffset: 4
                }]
            },
            options: {
                indexAxis: 'y',



            }


        });
    </script>


</x-app-layout>
