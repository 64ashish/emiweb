<div class="grid grid-cols-2 gap-x-6 gap-y-4">
@foreach($filterAttributes as $filterAttribute)
    <div class="sm:grid sm:grid-cols-3 sm:items-start">
        <label for="{{ $filterAttribute }}"
               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            {{ __(ucfirst(str_replace('_', ' ', $filterAttribute))) }} </label>
        <div class="mt-1 sm:mt-0 sm:col-span-2  flex gap-x-2">
            @if(str_contains(str_replace('_', ' ', $filterAttribute), 'date') or $filterAttribute === "dob")
                <div class="flex gap-2">
                    {!! Form::text("array_".$filterAttribute."[year]", null,
                   ['class' => 'max-w-lg w-24 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                   sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                   'id' => $filterAttribute."_year", 'x-mask' => "9999",'placeholder' => "YYYY",]) !!}
                    {!! Form::text("array_".$filterAttribute."[month]", null,
                   ['class' => 'max-w-lg block w-14  shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                   sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                   'id' => $filterAttribute."_month", 'x-mask' => "99",'placeholder' => "MM",]) !!}
                    {!! Form::text("array_".$filterAttribute."[day]", null,
                   ['class' => 'max-w-lg w-14  block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                   sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                   'id' => $filterAttribute."_day", 'x-mask' => "99",'placeholder' => "DD",]) !!}
                </div>

            @elseif(in_array($filterAttribute, $enableQueryMatch))
                    {!! Form::text('qry_'.$filterAttribute.'[value]', null,
                                    ['class' => 'max-w-lg block w-2/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                     sm:text-sm border-gray-300 rounded-md',
                                    'id' => $filterAttribute.'_value']) !!}

                    {!! Form::select('qry_'.$filterAttribute.'[method]', [
                                null => 'Innehåller',
                                'start' => 'Börjar med',
                                'end' => 'Slutar med',
                                'exact' => 'Exakt'
                                ], null,['class' => 'max-w-lg block w-1/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md']); !!}

            @elseif($filterAttribute === 'from_province')
                {!! Form::select($filterAttribute,
                                $provinces,null,
                                [
                                    'class' => 'mt-1 block w-full rounded-md border-gray-300
                                 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                  focus:ring-indigo-500 sm:text-sm',
                                  'placeholder' => 'Select'
                              ]) !!}
            @elseif($filterAttribute === 'to_county')
                {!! Form::select($filterAttribute,
                                $provinces,null,
                                [
                                    'class' => 'mt-1 block w-full rounded-md border-gray-300
                                 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                  focus:ring-indigo-500 sm:text-sm',
                                  'placeholder' => 'Select'
                              ]) !!}
            @else
                {!! Form::text($filterAttribute, null,
                        ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                         sm:text-sm border-gray-300 rounded-md',
                        'id' => $filterAttribute]) !!}

{{--                {{ $ }}--}}
            @endif

        </div>
    </div>
@endforeach
</div>
<div  x-data="{ expanded: false }">
    <a  @click="expanded = ! expanded" class="py-4 inline-flex items-center cursor-pointer">

           <span x-show="expanded">
               {{ __("Hide advanced search") }}
           </span>
            <span x-show="! expanded">

            {{ __("Show advanced search") }}
           </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>


    </a>
    <div class="grid grid-cols-2 gap-x-6 gap-y-4" x-show="expanded" x-collapse.duration.1000ms>

        @foreach($advancedFields as $advancedField)
            <div class="sm:grid sm:grid-cols-3 sm:items-start">
                <label for="{{ $advancedField }}"
                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    {{ __(ucfirst(str_replace('_', ' ', $advancedField))) }} </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2   flex gap-x-2">

                    @if(str_contains(str_replace('_', ' ', $advancedField), 'date') or $advancedField === "dob")
                        <div class="flex gap-2">
                            {!! Form::text("array_".$advancedField."[year]", null,
                           ['class' => 'max-w-lg w-24 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                           sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                           'id' => $advancedField."_year", 'x-mask' => "9999",'placeholder' => "YYYY",]) !!}
                            {!! Form::text("array_".$advancedField."[month]", null,
                           ['class' => 'max-w-lg block w-14  shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                           sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                           'id' => $advancedField."_month", 'x-mask' => "99",'placeholder' => "MM",]) !!}
                            {!! Form::text("array_".$advancedField."[day]", null,
                           ['class' => 'max-w-lg w-14  block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                           sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                           'id' => $advancedField."_day", 'x-mask' => "99",'placeholder' => "DD",]) !!}
                        </div>

                    @elseif(in_array($advancedField, $enableQueryMatch))
                            {!! Form::text('qry_'.$advancedField.'[value]', null,
                                            ['class' => 'max-w-lg block w-2/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                             sm:text-sm border-gray-300 rounded-md',
                                            'id' => $advancedField.'_value']) !!}

                            {!! Form::select('qry_'.$advancedField.'[method]', [
                                        null => 'Innehåller',
                                        'start' => 'Börjar med',
                                        'end' => 'Slutar med',
                                        'exact' => 'Exakt'
                                        ], null,['class' => 'max-w-lg block w-1/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                             sm:text-sm border-gray-300 rounded-md']); !!}
                    @else
                        {!! Form::text($advancedField, null,
                        ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                         sm:text-sm border-gray-300 rounded-md',
                        'id' => $advancedField]) !!}
                    @endif



                </div>
            </div>
        @endforeach
    </div>
</div>


<div class="sm:flex justify-end pt-4 gap-x-5">
    @if(Str::is('*search', Route::currentRoutename()) == true)
    <a href="{{ route('records', $archive_name->id) }}"  class="inline-flex items-center px-8 py-2  text-base font-mediumtext-base ">{{ __('Clear search fields') }}</a>
    @else
        <a href="{{ route('records', $archive->id) }}"  class="inline-flex items-center px-8 py-2  text-base font-mediumtext-base ">{{ __('Clear search fields') }}</a>
    @endif

    <button type="submit" name="action" value="search" class="inline-flex items-center px-8 py-2 border
                                        border-transparent text-base font-medium rounded-md shadow-sm text-white
                                        {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700 focus:outline-none focus:ring-2
                                        focus:ring-offset-2 focus:ring-indigo-500">{{ __('Wide search') }}</button>
    <button type="submit" name="action" value="filter" class=" inline-flex items-center px-8 py-2 border
                                        border-transparent text-base font-medium rounded-md shadow-sm text-white
                                        {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700 focus:outline-none focus:ring-2
                                        focus:ring-offset-2 focus:ring-indigo-500">{{ __('Exact search') }}</button>

</div>
