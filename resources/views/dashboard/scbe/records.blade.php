<x-app-layout>
    <!-- Main 3 column grid -->
    @include('dashboard._breadcrumb')

    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section {{ (Str::is('*search', Route::currentRoutename()) == true)? "x-data=data()":false }}
                 class="pt-6" aria-labelledby="section-1-title">

            <div x-show="!openDetails" class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                    {{ __('Search in') }}  SCB Emigranter
                </p>


                    @if(isset($keywords))
                        {!! Form::model($keywords,['route' => 'sesrc.search'])  !!}
                    @endif
                    @if(!isset($keywords))
                        {!! Form::open(['route' => 'sesrc.search'])  !!}
                    @endif

                <div class="grid grid-cols-2 gap-x-6 gap-y-4 pb-4">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="qry_first_name[]" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('First name') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 flex gap-x-2">

                            {!! Form::text('qry_first_name[value]', null,
                            ['class' => 'max-w-lg block w-2/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'first_name']) !!}

                            {!! Form::select('qry_first_name[method]', [
                                        null => 'Innehåller',
                                        'start' => 'Börjar med',
                                        'end' => 'Slutar med',
                                        'exact' => 'Exakt'
                                        ], null,['class' => 'max-w-lg block w-1/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md']); !!}
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ __('Last name') }} </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 flex gap-x-2">

                            {!! Form::text('qry_last_name[value]', null,
                            ['class' => 'max-w-lg block w-2/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'last_name']) !!}

                            {!! Form::select('qry_last_name[method]', [
                                        null => 'Innehåller',
                                        'start' => 'Börjar med',
                                        'end' => 'Slutar med',
                                        'exact' => 'Exakt'
                                        ], null,['class' => 'max-w-lg block w-1/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md']); !!}
                        </div>
                    </div>
                </div>

                        @include('dashboard._filtersattributes')


                    {!! Form::close() !!}


            </div>

            @if(isset($records) and $records->count() > 0)

                @include('dashboard._resultandquickview')
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
