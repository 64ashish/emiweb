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

            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-lg mt-4 font-bold text-gray-900   pb-4">
                    {{ __('Search in') }}  {{ __($archive_name->name) }}

                </p>

                    @if(isset($keywords))
                        {!! Form::model($keywords,['route' => 'scerc.search', 'x-data'])  !!}
                    @endif
                    @if(!isset($keywords))
                        {!! Form::open(['route' => 'scerc.search'])  !!}
                    @endif
                    <?php if(isset($archive->id) && $archive->id != ''){
                        $arc_id = $archive->id;
                    }else if(isset($archive['id']) && !empty($archive)){
                        $arc_id = $archive['id'];
                    }else{
                        $arc_id = '';
                    } ?>
                        <input type="hidden" name="archive_id" value="{{ $arc_id }}">
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
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function (){
            var sortBy = '{{request('sortBy')}}';
            var page = '{{request('page')}}';
            if(sortBy && page == 1){
                $('.clickable').each(function(){
                    var column = $.trim($(this).text());

                    if(column === sortBy){
                        $(this).click();
                    };
                })
            }

            setTimeout(() => {
                if ($('#tr').length) {
                    $('#tr').click();
                }
            }, 500);
        })

       /* if(sortBy){
            const columns = document.querySelectorAll(".clickable");
            for (var i = 0; i < columns.length; i++) {
                if(columns[i].innerText === sortBy){
                    columns[i].click();
                };
            }
        }*/

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
                    var page = '{{request('page')}}';
                    if(page > 1){
                        var url = new URL(@json( $records )['first_page_url']);
                        url.searchParams.append('sortBy', $event.target.innerText);
                        window.location.href = url;
                    }

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
