<x-app-layout>
    <!-- Main 3 column grid -->
    @include('dashboard._breadcrumb')

    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section class="pt-6" aria-labelledby="section-1-title">
            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                    {{ __('Search in') }} Dalslänningar födda i Amerika
                </p>



                @if(isset($keywords))
                {!! Form::model($keywords,['route' => 'dbir.search']) !!}
                @endif
                @if(!isset($keywords))
                {!! Form::open(['route' => 'dbir.search']) !!}
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
            @elseif(\Illuminate\Support\Facades\Route::currentRouteName() !== "records")
                <div class="pt-6">
                    {{ __('Your search returned no results') }}
                </div>

            @endif
        </section>

    </div>
</x-app-layout>
