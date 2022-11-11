<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section
                class="pt-6" aria-labelledby="section-1-title">


            <div  class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                    {{ __('Search in') }}  Riksföreningen Sverigekontakt's personal history archive

                </p>

                @if(isset($keywords))
                    {!! Form::model($keywords,['route' => 'rsphr.search'])  !!}
                @endif
                @if(!isset($keywords))
                    {!! Form::open(['route' => 'rsphr.search'])  !!}
                @endif

                @include('dashboard._filtersattributes')


                {!! Form::close() !!}


            </div>


            @if(isset($records) and $records->count() > 0)

                <div class="mt-8 flex flex-col" x-init="document.getElementById('results').scrollIntoView()"
                        {{ (Str::is('rsphr.search', Route::currentRoutename()) == true)? "x-data=data()":false }}>
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
                                            <li class="w-1/3 py-2 pl-4 pr-3 sm:pl-6 lg:pl-8">{{ __('Name') }}</li>
                                            <li class="w-1/3 py-2 pl-4 pr-3 sm:pl-6 lg:pl-8">{{ __('Profession') }}</li>
                                            <li class="w-1/4 py-2 pl-4 pr-3 sm:pl-6 lg:pl-8">{{ __('Country') }}</li>
                                            <li class="w-1/6 py-2 pl-4 pr-3 sm:pl-6 lg:pl-8">{{ __('Source') }}</li>
                                        </ul>
                                    </div>
                                    <div id="results-body" class="grid bg-white border-b border-gray-300">
                                        @foreach($records as $record)
                                            <ul  @click="openPhotoViewer =! openPhotoViewer, openPhoto({{ $record->id  }})"
                                                 id="results-row"
                                                 class="inline-flex odd:bg-white even:bg-gray-100 hover:bg-indigo-700 text-gray-900 hover:text-white cursor-pointer">
                                                <li class="w-1/3 py-2 pl-4 pr-3 text-sm font-medium  sm:pl-6 lg:pl-8">{{ $record->name }}</li>
                                                <li class="w-1/3 py-2 pl-4 pr-3 text-sm font-medium  sm:pl-6 lg:pl-8">{{ $record->profession }}</li>
                                                <li class="w-1/4 py-2 pl-4 pr-3 text-sm font-medium  sm:pl-6 lg:pl-8">{{ $record->country }}</li>
                                                <li class="w-1/6 py-2 pl-4 pr-3 text-sm font-medium  sm:pl-6 lg:pl-8">{{ $record->source }}</li>

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
                                                    <div class="flex flex-wrap">
                                                        <img :src="imageURL" x-show="fileType != 'pdf'">
                                                        <iframe x-show="fileType == 'pdf'" class="w-full h-96" :src="imageURL"></iframe>
                                                        <div class="p-5 flex flex-col justify-between w-full ">
                                                            <ul class="text-sm font-medium">
                                                                <li>Rubrik: <span x-text="photoDetail['name']"></span></li>
                                                                <li>Beskrivning:<span x-text="photoDetail['profession']"></span></li>
                                                                <li>Personer på bilden  :<span x-text="photoDetail['country']"></span></li>
                                                                <li>  Fotograf:<span x-text="photoDetail['source']"></span></li>

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

                    @elseif(\Illuminate\Support\Facades\Route::currentRouteName() !== "records")
                        <div class="pt-6">
                            {{ __('Your search returned no results') }}
                        </div>
            @endif
        </section>

    </div>
    @if((Str::is('rsphr.search', Route::currentRoutename()) == true))
        <script>
            function data() {
                return {
                    openPhotoViewer: false,
                    photoRecords: @json($records->items()),
                    photoDetail:'',
                    next:'',
                    previous:'',
                    imgBaseUrl: @json(\Illuminate\Support\Facades\Storage::disk('s3')->url('archives/26/images')),
                    imageURL:'',
                    fileType:'',
                    openPhoto(id){
                        let totalImages = this.photoRecords.length
                        this.photoDetail = this.photoRecords.find(x => x.id === id);
                        let selectedPhotoIndex = this.photoRecords.findIndex(e => e.id == id );
                        this.next = selectedPhotoIndex != totalImages-1 ? this.photoRecords[selectedPhotoIndex+1].id:false;
                        this.previous = selectedPhotoIndex > 0 ? this.photoRecords[selectedPhotoIndex-1].id:false;
                        this.imageURL = this.imgBaseUrl+this.photoDetail['filename']
                        this.fileType = this.photoDetail['filename'].split('.').reverse()[0]

                    }
                }
            }
        </script>
    @endif


</x-app-layout>
