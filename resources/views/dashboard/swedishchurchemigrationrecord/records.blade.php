<x-app-layout>
    <!-- Main 3 column grid -->
    @include('dashboard._breadcrumb')
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section {{ (Str::is('*search', Route::currentRoutename()) == true)? "x-data=data()":false }}
                 class="pt-6" aria-labelledby="section-1-title">

            <ul class="flex gap-x-5 justify-end mr-8 mb-[18px]">
                <li >
                    <a class="p-5 bg-indigo-600 text-white rounded-t-lg"
                     href="{{ route('scerc.statics') }}">
                      Statistik
                  </a>
                </li>

            </ul>

            <div x-show="!openDetails" class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                    {{ __('Search in') }}  Emigranter registrerade i svenska kyrkböcker
                    @if(Str::is('*search', Route::currentRoutename()) == true)
                        this is result page
                    @else
                        this is not result page
                    @endif
                </p>

                    @if(isset($keywords))
                        {!! Form::model($keywords,['route' => 'scerc.search', 'x-data'])  !!}
                    @endif
                    @if(!isset($keywords))
                        {!! Form::open(['route' => 'scerc.search'])  !!}
                    @endif

                        <div class="grid grid-cols-2 gap-4 pb-4">
                            <div class="sm:grid sm:grid-cols-3 sm:items-start">
                                <label for="first_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ __('First name') }} </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">

                                    {!! Form::text('first_name', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'first_name']) !!}
                                    @error('first_name')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:items-start">
                                <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ __('Last name') }} </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">

                                    {!! Form::text('last_name', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'last_name']) !!}
                                    @error('last_name')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror
                                </div>
                            </div>
                        </div>

                        @include('dashboard._filtersattributes')


                    {!! Form::close() !!}


            </div>


            @if(isset($records) and $records->count() > 0)

                @include('dashboard._resultandquickview')
{{--                @include('dashboard.swedishchurchemigrationrecord.alp')--}}
{{--                @include('dashboard.swedishchurchemigrationrecord.alp')--}}
            @elseif(\Illuminate\Support\Facades\Route::currentRouteName() !== "records")
                <div class="pt-6">
                    {{ __('Your search returned no results') }}
                </div>

            @endif
        </section>

    </div>

@if((Str::is('*search', Route::currentRoutename()) == true))
    <script>
        function data() {
            return {
                openDetails: false,
                displayFields:@json($fieldsToDisply),
                detail:'',
                next:'',
                previous:'',
                initialRecords: @json($records->items()),
                sortBy: '',
                sortAsc: false,
                recordURL: '',
                nextPage: @json($records->nextPageUrl()),
                previousPage: @json( $records->nextPageUrl()),
                // currentPageLength:

                // selectedIndex:'',

                selectedRecord(recordId){
                    let recordsLength = this.initialRecords.length;
                    this.detail = this.initialRecords.find(x => x.id === recordId);
                    // let selectedIndex = this.initialRecords.findIndex(this.detail)
                    let selectedIndex = this.initialRecords.findIndex(e => e.id == recordId );
                    this.next = selectedIndex != recordsLength-1 ? this.initialRecords[selectedIndex+1].id:false;
                    this.previous = selectedIndex > 0 ? this.initialRecords[selectedIndex-1].id:false;
                    this.recordURL = "/records/"+this.detail.archive_id+"/"+this.detail.id;
                },

                sortByColumn($event) {
                    if (this.sortBy === $event.target.innerText) {
                        if (this.sortAsc) {
                            this.sortBy = "";
                            this.sortAsc = false;
                        } else {
                            this.sortAsc = !this.sortAsc;
                        }
                    } else {
                        this.sortBy = $event.target.innerText;
                    }

                    let rows = this.getTableRows()
                        .sort(
                            this.sortCallback(
                                Array.from($event.target.parentNode.children).indexOf(
                                    $event.target
                                )
                            )
                        )
                        .forEach((tr) => {
                            this.$refs.tbody.appendChild(tr);
                        });
                },
                getTableRows() {
                    return Array.from(this.$refs.tbody.querySelectorAll("tr"));
                },
                getCellValue(row, index) {
                    return row.children[index].innerText;
                },
                sortCallback(index) {
                    return (a, b) =>
                        ((row1, row2) => {
                            return row1 !== "" &&
                            row2 !== "" &&
                            !isNaN(row1) &&
                            !isNaN(row2)
                                ? row1 - row2
                                : row1.toString().localeCompare(row2);
                        })(
                            this.getCellValue(this.sortAsc ? a : b, index),
                            this.getCellValue(this.sortAsc ? b : a, index)
                        );
                }
            }

        }
    </script>
    @endif
</x-app-layout>
