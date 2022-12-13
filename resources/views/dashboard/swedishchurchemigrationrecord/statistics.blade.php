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
                        Statistiks
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
                             'placeholder' => 'Alla'
                             ]) !!}
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="comparison" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Jämförelseområde') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            {!! Form::select('from_province_compare', $provinces,null,['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                             sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                             'placeholder' => 'Do not compare'
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
                    label: {{ Js::from($keywords['from_province']) }},
                    grouped:true,
                    maxBarThickness:'50',
                    data: {{ Js::from($data->pluck('total')) }},
                    {{--backgroundColor:'#344D67':poolColors({{ Js::from($data->pluck('total')->count()) }}),--}}
                    backgroundColor: {{ Js::from($chart_type) }} === 'bar'?'#344D67':poolColors({{ Js::from($data->pluck('total')->count()) }}),

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
                },
                    @if($data2 != null )
                    {
                        label: {{ Js::from($keywords['from_province_compare']) }},
                        grouped:true,
                        maxBarThickness:'50',
                        data: {{ Js::from($data2->pluck('total')) }},
                        // backgroundColor: '#6ECCAF',
                        backgroundColor: {{ Js::from($chart_type) }} === 'bar'?'#6ECCAF':poolColors({{ Js::from($data2->pluck('total')->count()) }}),

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
                    }
                    @endif
                ]
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
        <script >
            const counties =[
                {
                    "Blekinge": [
                        "Aspö",
                        "311",
                        "Asarum",
                        "Augerum",
                        "Edestad",
                        "Bräkne-hoby",
                        "Backaryd",
                        "Eringsboda",
                        "Elleholm",
                        "Flyman",
                        "Fridlevstad",
                        "Flymen",
                        "Förkärla",
                        "Gammelstorp",
                        "Gammalstorp",
                        "Hasslö",
                        "Hjortsberga",
                        "Hemse",
                        "Hussaryd",
                        "Jämjö",
                        "Hästaryd 1",
                        "Hällaryd",
                        "Kallinge",
                        "Jämshög",
                        "Karlshamn",
                        "Karl Gustav",
                        "Karlskrona Amiralitetsförs",
                        "Karlskrona Amiralitetsförsamling",
                        "Karlskrona Amiralitets",
                        "Kristianopel",
                        "Karlskrona stadsförs",
                        "Ky",
                        "Kvikkjokk",
                        "Kyrkhult",
                        "Lösen",
                        "Listerby",
                        "Mjällby",
                        "Nättraby",
                        "Mörrum",
                        "Obeflboken",
                        "Ramdala",
                        "R",
                        "Ringamåla",
                        "Ronneby 'land'",
                        "Ronneby 'stad'",
                        "Ronneby",
                        "Sturkö",
                        "Rödeby",
                        "Sillhövda",
                        "Sölvesborg",
                        "Sölvesborgs landsförs",
                        "Sölvesborgs stadsförs",
                        "Sölvesborgs Stadsförsamling",
                        "Torhamn",
                        "Tingsås",
                        "Tjurkö",
                        "Torhamnb",
                        "Ysane",
                        "Visby Sfs",
                        "Tving",
                        "Öja",
                        "Åryd",
                        "Öljehult"
                    ]
                },
                {
                    "Gotland": [
                        "155",
                        "Akebäck",
                        "Ala",
                        "Alskog",
                        "Alustralien",
                        "Alva",
                        "Amerika",
                        "Anerika",
                        "Anga",
                        "Ardre",
                        "Atlingbo",
                        "Barlingbo",
                        "Bjärs",
                        "Björke",
                        "Boge",
                        "Bomunds I Hammaren",
                        "Botvalda",
                        "Bro",
                        "Bunge",
                        "Burs",
                        "Busarve",
                        "Buttle",
                        "Bäl",
                        "Böljke",
                        "Californien",
                        "Chicago",
                        "Dahlhem",
                        "Dalhem",
                        "E",
                        "Ejmunds",
                        "Eke",
                        "Ekeby",
                        "Eksta",
                        "Ende",
                        "Endre",
                        "Eskelhem",
                        "Etelhem",
                        "Fardhem",
                        "Farhem",
                        "Fide",
                        "Fleringe",
                        "Fole",
                        "Follingbo",
                        "Foss",
                        "Frdhem",
                        "Fröjel",
                        "Fårö",
                        "Gammelgarn",
                        "Ganthem",
                        "Garde",
                        "Gemmelgarn",
                        "Gerum",
                        "Gothem",
                        "Grötlingbo",
                        "Guldrupe",
                        "Hablingbo",
                        "Hall",
                        "Halla",
                        "Hamra",
                        "Hangavar",
                        "Hangvar",
                        "Havdhem",
                        "Hejde",
                        "Hejdeby",
                        "Hejnum",
                        "Hellvi",
                        "Hemse",
                        "Hogrän",
                        "Hörsne Med Bara",
                        "Klinte",
                        "Kristianopel",
                        "Kräklingbo",
                        "Kville",
                        "Kyrkhult",
                        "Källunge",
                        "Lau",
                        "Levide",
                        "Linde",
                        "Lojsta",
                        "Lokrume",
                        "Lummelunda",
                        "Lye",
                        "Lärbro",
                        "Maria Magdalena",
                        "Martebo",
                        "Mästerby",
                        "Mörrum",
                        "Nord Amerika",
                        "Norra Valla",
                        "Norrlanda",
                        "När",
                        "Näs",
                        "Othem",
                        "R",
                        "Ringamåla",
                        "Roma",
                        "Rone",
                        "Rute",
                        "Ruthe",
                        "Sanda",
                        "Silte",
                        "Sindarfve",
                        "Sjonhem",
                        "Skee",
                        "Skogs",
                        "Stelor",
                        "Stenkumla",
                        "Stenkyrka",
                        "Stora Gervide",
                        "Stånga",
                        "Sundre",
                        "Tibble",
                        "Tingstäde",
                        "Tofa",
                        "Tofta",
                        "Tofte",
                        "Toftra",
                        "Torhamn",
                        "Träkumla",
                        "Täkumla",
                        "Vall",
                        "Vallstena",
                        "Vamlingbo",
                        "Vamlingsbo",
                        "Vaters",
                        "Vemlinge",
                        "Viklau",
                        "Visby",
                        "Visby Lfs",
                        "Visby S",
                        "Visby Sfs",
                        "Visby Stadsförs",
                        "Vänge",
                        "Väskinde",
                        "Västerbjers",
                        "Västergarn",
                        "Västergarng",
                        "Västerhejde",
                        "Väte",
                        "Öja",
                        "Östergarn"
                    ]
                },
                {
                    "Gävleborg":[
                        "Alfta",
                        "Annefors",
                        "Arbrå",
                        "Bergsjö",
                        "Bergvik",
                        "Bjuråker",
                        "Bokenäs",
                        "Bollnäs",
                        "Delsbo",
                        "Enånger",
                        "Eskelhem",
                        "Forsa",
                        "Färila",
                        "Gnarp",
                        "Grebbestad",
                        "Gävle",
                        "Gävle Heliga Trefaldighet",
                        "Gävle Staffan",
                        "Hamrånge",
                        "Hanebo",
                        "Harmånger",
                        "Harmångers",
                        "Hassela",
                        "Hedesunda",
                        "Hemse",
                        "Hille",
                        "Hofors",
                        "Hudiksvall",
                        "Hälsingtuna",
                        "Hög",
                        "Högbo",
                        "Idenor",
                        "Ilsbo",
                        "Järbo",
                        "Järvsö",
                        "Jättendal",
                        "Katrineberg",
                        "Kårböle",
                        "Lingbo",
                        "Ljusdal",
                        "Ljusne",
                        "Los",
                        "Mo",
                        "Nianfors",
                        "Njutånger",
                        "Norrala",
                        "Norrbo",
                        "Ockelbo",
                        "Ovansjö",
                        "Ovanåker",
                        "Ramsjö",
                        "Rengsjö",
                        "Rogsta",
                        "Sandarne",
                        "Sandviken",
                        "Sandviken (högbo)",
                        "Segersta",
                        "Skog",
                        "Svabensverk",
                        "Söderala",
                        "Söderhamn",
                        "Torsåker",
                        "Trönö",
                        "Undersvik",
                        "Valbo",
                        "Voxna",
                        "Åmot",
                        "Årsunda",
                        "Österfärnebo"
                    ]
                },
                {
                    "Göteborgs och Bohus": [
                        "A0022691",
                        "Ambjörnarp",
                        "Anfasteröd",
                        "Angered",
                        "Aröd",
                        "Asarum",
                        "Askim",
                        "Askum",
                        "Backa",
                        "Bergen",
                        "Berghem",
                        "Bergum",
                        "Björketorp",
                        "Björlanda",
                        "Bokenäs",
                        "Bottna",
                        "Brastad",
                        "Bro",
                        "Brofve",
                        "Bräcke",
                        "Bärfendal",
                        "Bärfendalgö",
                        "Bäve",
                        "Dragsmark",
                        "Dyrhuvud",
                        "Fiskebäckskil",
                        "Fjällbacka",
                        "Forshälla",
                        "Forsmark",
                        "Foss",
                        "Frillestad",
                        "Frändefors",
                        "Fässberg",
                        "Gamlestads  Församling",
                        "Gbg S Annedal",
                        "Gbg S Domkyrko",
                        "Gbg S Gamelstad",
                        "Gbg S Gamlestad",
                        "Gbg S Garnison",
                        "Gbg S Haga",
                        "Gbg S Hospital",
                        "Gbg S Johanneberg",
                        "Gbg S Karl Johan",
                        "Gbg S Kristine",
                        "Gbg S Marieberg",
                        "Gbg S Masthugg",
                        "Gbg S Oscar Fredrik",
                        "Gbg S Vasa",
                        "Gbg:s Domkyrko",
                        "Gbg:s Gaamlestad",
                        "Gbg:s Gamlestad",
                        "Gbg:s Karl Johan",
                        "Gbg:s Nya Varvet",
                        "Gbg:s Oscar Fredrik",
                        "Gbg:s Örgryte",
                        "Glasbruket",
                        "Grebbestad",
                        "Grinneröd",
                        "Grundsund",
                        "Gullholmen",
                        "Gusseröd",
                        "Gustavi Domkyrkoförsamling",
                        "Göteborg",
                        "Göteborg Karl Johan",
                        "Göteborg Kristine",
                        "Göteborgs Domkyrko",
                        "Göteborgs Domkyrkoförsamling",
                        "Göteborgs Haga",
                        "Göteborgs Karl Johan",
                        "Göteborgs Kristine",
                        "Göteborgs Oscar Fredrik",
                        "Haga",
                        "Hakmstad",
                        "Harestad",
                        "Hede",
                        "Herrestad",
                        "Hishult",
                        "Hogdal",
                        "Hunnebostrand",
                        "Hälle",
                        "Härryda",
                        "Håby",
                        "Hålta",
                        "Högstorp",
                        "Högås",
                        "Infl. Bok 25/28",
                        "Iskebäckskil",
                        "Jonsered",
                        "Jörlanda",
                        "Kareby",
                        "Kikerud Tågbacken",
                        "Klädesholmen",
                        "Klädesholmen Stenvik",
                        "Klövedal",
                        "Kristine",
                        "Krokstad",
                        "Kungshamn",
                        "Kungälv",
                        "Kvile",
                        "Kville",
                        "Kämperöd",
                        "Käringön",
                        "Kållered",
                        "Kållereds",
                        "Landvetter",
                        "Lane-ryr",
                        "Lilla Harrie",
                        "Lindome",
                        "Ljung",
                        "Lommeland",
                        "Lundby",
                        "Lur",
                        "Lycke",
                        "Lyse",
                        "Lysekil",
                        "Långelanda",
                        "Malmön",
                        "Mamön",
                        "Marstrand",
                        "Mo",
                        "Mollösund",
                        "Morlanda",
                        "Myckleby",
                        "Na",
                        "Naverstad",
                        "Nor",
                        "Norge",
                        "Norum",
                        "Nya Varvet",
                        "Näsinge",
                        "Nödinge",
                        "Partille",
                        "Resteröd",
                        "Romelanda",
                        "Råda",
                        "Rödbo",
                        "Rönnäng",
                        "Röra",
                        "Sanne",
                        "Sanne Församling",
                        "Sannw",
                        "Skaftö",
                        "Skee",
                        "Skefteröd",
                        "Skredsvik",
                        "Skälläckeröd",
                        "Solberga",
                        "Spekeröd",
                        "St",
                        "Stala",
                        "Stenebyn",
                        "Stenkyrka",
                        "Strömstad",
                        "Styrsö",
                        "Svarteborg",
                        "Säve",
                        "Södra Vi",
                        "Tanum",
                        "Tegneby",
                        "Tierp",
                        "Tjärnö",
                        "Tjärstad",
                        "Torp",
                        "Torsby",
                        "Torslanda",
                        "Tossene",
                        "Tuve",
                        "Tuve Församling",
                        "Ucklum",
                        "Uddevalla",
                        "Valbo Ryr",
                        "Valbo-ryr",
                        "Valboryr",
                        "Valla",
                        "Vasa",
                        "Västra Frölunda",
                        "Ytterby",
                        "Älvsborg",
                        "Öckerö",
                        "Öckerö Sörgård Skolhuset",
                        "Ödsmål",
                        "Örgryte"
                    ]
                },
                {
                    "Halland": [
                        "Tvååker",
                        "Våxtorp",
                        "värö",
                        "12",
                        "Abild",
                        "Alfsgård",
                        "Alfshög",
                        "Asige",
                        "Askome",
                        "Breard",
                        "Breared",
                        "Dagsås",
                        "Danmark",
                        "Dr'ängsered",
                        "Drängserd",
                        "Drängsered",
                        "Drängsred",
                        "Eftra",
                        "Eldsberga",
                        "Enslöv",
                        "Fagered",
                        "Falkenberg",
                        "Fjärås",
                        "Frillesås",
                        "Färgaryd",
                        "Förlanda",
                        "Getinge",
                        "Grimeton",
                        "Grimmared",
                        "Gunnarp",
                        "Gunnarsjö",
                        "Gällared",
                        "Gällinge",
                        "Gödestad",
                        "Halmstad",
                        "Hanhals",
                        "Harplinge",
                        "Hasslöv",
                        "Hemmesjö Med Tegnaby",
                        "Hishult",
                        "Holm",
                        "Hornborga",
                        "Hunnestad",
                        "Idala",
                        "Jälluntofta",
                        "Karl Gustav",
                        "Kinnared",
                        "Krogsered",
                        "Kungsbacka",
                        "Kungsäter",
                        "Kvibille",
                        "Källsjö",
                        "Köinge",
                        "Laholms Landsförsamling",
                        "Laholms landsförs",
                        "Laholms stadsförs",
                        "Landa",
                        "Lindberg",
                        "Ljungby",
                        "Långaryd",
                        "Morup",
                        "Nösslinge",
                        "Okome",
                        "Onsala",
                        "Rolfstorp",
                        "Ränneslöv",
                        "Rävinge",
                        "Råggärd",
                        "S",
                        "Sibbarp",
                        "Skrea",
                        "Skummeslöv",
                        "Skällinge",
                        "Släp",
                        "Slättåkra",
                        "Slöinge",
                        "Snöstorp",
                        "Spannarp",
                        "Stafsinge",
                        "Stamnared",
                        "Steninge",
                        "Steningeh",
                        "Stråvalla",
                        "Svartrå",
                        "Sällstorp",
                        "Sättåkra",
                        "Södra Unnaryd",
                        "Söndrum",
                        "T",
                        "Tjärby",
                        "Torhamn",
                        "Torpa",
                        "Träslöv",
                        "Trönninge",
                        "Tvååker",
                        "Tvååker 10",
                        "Tölö",
                        "Tönnersjö",
                        "Ullared",
                        "Vaberg",
                        "Valinge",
                        "Vallda",
                        "Vapnö",
                        "Varberf",
                        "Varberg",
                        "Varbergs Stadsförsamling",
                        "Veddige",
                        "Vessige",
                        "Vinberg",
                        "Vråen 3",
                        "Värfö",
                        "Värö",
                        "Väärö",
                        "Våxtop",
                        "Våxtorp",
                        "Våxtrop",
                        "Ysby",
                        "Älvsåker",
                        "Älvsåker Nr 2",
                        "Älvsåkr",
                        "Ärö",
                        "Å",
                        "Årsta",
                        "Årstad",
                        "Årstadq",
                        "Ås",
                        "Ölmevalla",
                        "Övraby"
                    ]
                },
                {
                    "Jämtland": []
                },
                {
                    "Jönköping": []
                },
                {
                    "Kalmar": []
                },
                {
                    "Kopparberg": []
                },
                {
                    "Kristianstad": []
                },
                {
                    "Kronoberg": []
                },
                {
                    "Malmöhus": []
                },
                {
                    "Norrbotten": []
                },
                {
                    "Skaraborg": []
                },
                {
                    "Stockholm": []
                },
                {
                    "Södermanland": []
                },
                {
                    "Uppsala": []
                },
                {
                    "Värmland": []
                },
                {
                    "Västerbotten": []
                },
                {
                    "Västernorrland": []
                },
                {
                    "Västmanland": []
                },
                {
                    "Älvsborg": []
                },
                {
                    "Örebro": []
                },
                {
                    "Östergötland": []
                }

            ]

            function parishAndCounties() {
                return {
                    id: "",
                    name: "",
                    datas: arraydata,
                    changeCategory() {
                        var e = document.getElementById("vehicle_id");
                        var value = e.options[e.selectedIndex].getAttribute("data-val");
                        this.datas = arraydata.filter((i) => {
                            return i.vehicle_category_id == value;
                        })
                    }
                };
            }
        </script>

</x-app-layout>
