<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section
                 class="pt-6" aria-labelledby="section-1-title">

            <ul class="flex gap-x-5 justify-end mr-8 mb-[18px]">
                <li >
                    <a class="p-5 bg-indigo-600 text-white rounded-t-lg"
                       href="{{ route('scerc.search') }}">

                        {{ __('Search Archive') }}
                    </a>
                </li>
                <li >
                    <a class="p-5 bg-indigo-600 text-white rounded-t-lg"
                       href="{{ route('scerc.photos') }}">

                        {{ __('Search photographer') }}
                    </a>
                </li>
                <li >
                    <a class="p-5 bg-indigo-600 text-white rounded-t-lg"
                       href="{{ route('scerc.statics') }}">
                        {{ __('Search Statistics') }}

                    </a>
                </li>
            </ul>

            <div  class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                    {{ __('Search in') }}  Emigranter registrerade i svenska kyrkböcker

                </p>

                @if(isset($keywords))
                    {!! Form::model($keywords,['route' => 'scerc.result-photos'])  !!}
                @endif
                @if(!isset($keywords))
                    {!! Form::open(['route' => 'scerc.result-photos'])  !!}
                @endif

                <div class="grid grid-cols-2 gap-4 pb-4">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Rubrik') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('title', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'title']) !!}
                            @error('title')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Beskrivning') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('description', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'description']) !!}
                            @error('description')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Tidsperiod') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('time_period', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'time_period']) !!}
                            @error('time_period')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Land') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('country', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'country']) !!}
                            @error('country')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Stat/Provins/Län(County)') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('state_province_county', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'state_province_county']) !!}
                            @error('state_province_county')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Stad/Samhälle/By') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('locality', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'locality']) !!}
                            @error('locality')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Personer på bilden') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('persons_on_photo', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'persons_on_photo']) !!}
                            @error('persons_on_photo')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Fotograf') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('photographer', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'photographer']) !!}
                            @error('photographer')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Arkivreferens') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('archive_reference', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'archive_reference']) !!}
                            @error('archive_reference')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>
                </div>

                <div class="sm:flex justify-end pt-4 gap-x-5">
                    <button type="submit"  class=" inline-flex items-center px-8 py-2 border
                                            border-transparent text-base font-medium rounded-md shadow-sm text-white
                                            {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700 focus:outline-none focus:ring-2
                                            focus:ring-offset-2 focus:ring-indigo-500">{{ __('Search photos') }}</button>
                </div>

                {!! Form::close() !!}


            </div>


            @if(isset($records) and $records->count() > 0)

                <div class="mt-8 flex flex-col" x-init="document.getElementById('results').scrollIntoView()"
                        {{ (Str::is('scerc.result-photos', Route::currentRoutename()) == true)? "x-data=data()":false }}>
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8" id="results">

                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <h4 class="pb-6">
                                {{ __("Your search returned") ." ". $records->total()." ". __("results") }}
                            </h4>
                            <div class="overflow-hidden shadow ring-1 mb-4 ring-black ring-opacity-5 md:rounded-lg">

                                <div id="results-wrapper">
                                    <div id="results-header bg-gray-50" class="grid">
                                        <ul class="inline-flex  border-b border-gray-300 bg-gray-50
                                bg-opacity-75 text-left text-sm font-semibold text-gray-900">
                                            <li class="w-1/3 py-2 pl-4 pr-3 sm:pl-6 lg:pl-8">Title</li>
                                            <li class="w-1/3 py-2 pl-4 pr-3 sm:pl-6 lg:pl-8">Description</li>
                                            <li class="w-1/4 py-2 pl-4 pr-3 sm:pl-6 lg:pl-8">Person on photo</li>
                                            <li class="w-1/6 py-2 pl-4 pr-3 sm:pl-6 lg:pl-8">photographer</li>
                                            <li  class="w-1/6 py-2 pl-4 pr-3 sm:pl-6 lg:pl-8">Time period</li>
                                        </ul>
                                    </div>
                                    <div id="results-body" class="grid bg-white border-b border-gray-300">
                                        @foreach($records as $record)
                                        <ul  @click="openPhotoViewer =! openPhotoViewer, openPhoto({{ $record->id  }})"
                                                id="results-row"
                                            class="inline-flex odd:bg-white even:bg-gray-100 hover:bg-indigo-700 text-gray-900 hover:text-white cursor-pointer">
                                            <li class="w-1/3  pl-4 pr-3 text-[0.7rem] leading-[0.7rem] sm:py-[0.6rem]  font-medium  sm:pl-6 lg:pl-8">{{ $record->title }}</li>
                                            <li class="w-1/3  pl-4 pr-3 text-[0.7rem] leading-[0.7rem] sm:py-[0.6rem]  font-medium  sm:pl-6 lg:pl-8">{{ $record->description }}</li>
                                            <li class="w-1/4  pl-4 pr-3 text-[0.7rem] leading-[0.7rem] sm:py-[0.6rem]  font-medium  sm:pl-6 lg:pl-8">{{ $record->persons_on_photo }}</li>
                                            <li class="w-1/6  pl-4 pr-3 text-[0.7rem] leading-[0.7rem] sm:py-[0.6rem]  font-medium  sm:pl-6 lg:pl-8">{{ $record->photographer }}</li>
                                            <li  class="w-1/6  pl-4 pr-3 text-[0.7rem] leading-[0.7rem] sm:py-[0.6rem]  font-medium  sm:pl-6 lg:pl-8">{{ $record->time_period }}</li>

                                        </ul>
                                        @endforeach
                                    </div>
                                    <div id="pagination-wrapper" class="p-5">
                                        {{ $records->appends(request()->except(['_token']))->links() }}
                                    </div>

                                    <div  x-show="openPhotoViewer"  x-transition:enter="ease-out duration-300"
                                          x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                          x-transition:leave="transition ease-in duration-75"
                                          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                          class="fixed inset-0 z-20 overflow-y-auto p-4 sm:p-6 md:p-20" role="dialog"
                                          aria-modal="true" style="display:none">
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity"
                                             aria-hidden="true"></div>

                                        <div x-transition:enter="ease-out duration-300"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="ease-in duration-200"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 opacity-100 scale-100"
                                             class="mx-auto max-w-4xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
                                            <div>
                                                <div  @click.away="openPhotoViewer = false">
                                                    <div class="grid grid-cols-2 lg:flex-row">
                                                        <img :src="imageURL">
                                                        <div class="p-5 flex flex-col justify-between w-full ">
                                                            <ul class="text-[0.7rem] leading-[0.7rem] sm:py-[0.6rem] font-medium">
                                                                <li class="pl-4 pr-3 sm:py-[0.6rem]">Rubrik: <span x-text="photoDetail['title']"></span></li>
                                                                <li class="pl-4 pr-3 sm:py-[0.6rem]">Beskrivning:<span x-text="photoDetail['description']"></span></li>
                                                                <li class="pl-4 pr-3 sm:py-[0.6rem]">Personer på bilden  :<span x-text="photoDetail['persons_on_photo']"></span></li>
                                                                <li class="pl-4 pr-3 sm:py-[0.6rem]">  Fotograf:<span x-text="photoDetail['photographer']"></span></li>
                                                                <li class="pl-4 pr-3 sm:py-[0.6rem]">Stat/Provins/Län(County):<span x-text="photoDetail['state_province_county']"></span></li>
                                                                <li class="pl-4 pr-3 sm:py-[0.6rem]">Stad/Samhälle/By:<span x-text="photoDetail['locality']"></span></li>
                                                                <li class="pl-4 pr-3 sm:py-[0.6rem]"> Land:<span x-text="photoDetail['country']"></span></li>
                                                                <li class="pl-4 pr-3 sm:py-[0.6rem]">Tidsperiod:<span x-text="photoDetail['time_period']"></span></li>
                                                            </ul>
                                                            <div class="inline-flex justify-between">
                                                                <button type="button" class="relative -ml-px inline-flex items-center border border-gray-300
                       bg-white px-4 py-4  text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500
                        focus:outline-none focus:ring-1 focus:ring-indigo-500" @click="openPhoto(previous)" x-show="previous">

                                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                                                    </svg>

                                                                </button>


                                                                <button type="button" class="relative -ml-px inline-flex items-center  border border-gray-300
                       bg-white px-4 py-4  text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500
                        focus:outline-none focus:ring-1 focus:ring-indigo-500" @click="openPhoto(next)" x-show="next">
                                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>





                </div>

            @elseif(\Illuminate\Support\Facades\Route::currentRouteName() !== "scerc.photos")
                <div class="pt-6">
                    {{ __('Your search returned no results') }}
                </div>
            @endif
        </section>

    </div>
    @if((Str::is('scerc.result-photos', Route::currentRoutename()) == true))
        <script>
            function data() {
                return {
                    openPhotoViewer: false,
                    photoRecords: @json($records->items()),
                    photoDetail:'',
                    next:'',
                    previous:'',
                    imgBaseUrl: @json(\Illuminate\Support\Facades\Storage::disk('s3')->url('archives/5/photos')),
                    imageURL:'',
                    openPhoto(id){
                        let totalImages = this.photoRecords.length
                        this.photoDetail = this.photoRecords.find(x => x.id === id);
                        let selectedPhotoIndex = this.photoRecords.findIndex(e => e.id == id );
                        this.next = selectedPhotoIndex != totalImages-1 ? this.photoRecords[selectedPhotoIndex+1].id:false;
                        this.previous = selectedPhotoIndex > 0 ? this.photoRecords[selectedPhotoIndex-1].id:false;
                        this.imageURL = encodeURI(this.imgBaseUrl+this.photoDetail['file_name'].replaceAll(' ', '+'))

                    }
                }
            }
        </script>
    @endif


</x-app-layout>
