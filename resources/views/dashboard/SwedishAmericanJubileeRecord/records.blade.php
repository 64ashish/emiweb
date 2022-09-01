<x-app-layout>
    <!-- Main 3 column grid -->
    @include('dashboard._breadcrumb')
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section class="pt-6" aria-labelledby="section-1-title">
            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                    {{ __('Search in') }}  Svenskamerikanska jubileumsskrifter
                </p>


                @if(isset($keywords))
                    {!! Form::model($keywords,['route' => 'sajr.search']) !!}
                @endif
                @if(!isset($keywords))
                    {!! Form::open(['route' => 'sajr.search']) !!}
                @endif


                @include('dashboard._filtersattributes')


                {!! Form::close() !!}


            </div>
            @if(isset($records) and $records->count() > 0)

                @include('dashboard._resulttable')
            @elseif(\Illuminate\Support\Facades\Route::currentRouteName() !== "records")
                <div class="pt-6">
                    {{ __('Your search returned no results') }}
                </div>

            @endif
        </section>
    </div>
</x-app-layout>
