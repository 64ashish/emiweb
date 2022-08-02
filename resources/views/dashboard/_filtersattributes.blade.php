<div class="grid grid-cols-2 gap-4">
@foreach($filterAttributes as $filterAttribute)
    <div class="sm:grid sm:grid-cols-3 sm:items-start">
        <label for="{{ $filterAttribute }}"
               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            {{ __(ucfirst(str_replace('_', ' ', $filterAttribute))) }} </label>
        <div class="mt-1 sm:mt-0 sm:col-span-2">
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

            @else
            {!! Form::text($filterAttribute, null,
                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                    'id' => $filterAttribute]) !!}
            @endif

        </div>
    </div>
@endforeach
</div>
<h4 class="py-4">{{ __("Advanced search") }}</h4>
<div class="grid grid-cols-2 gap-4">

@foreach($advancedFields as $advancedField)
    <div class="sm:grid sm:grid-cols-3 sm:items-start">
        <label for="{{ $advancedField }}"
               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            {{ __(ucfirst(str_replace('_', ' ', $advancedField))) }} </label>
        <div class="mt-1 sm:mt-0 sm:col-span-2">

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
            @else
                {!! Form::text($advancedField, null,
                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                    'id' => $advancedField]) !!}
            @endif



        </div>
    </div>
@endforeach
</div>

<div class="sm:flex justify-around pt-4">

    <button type="submit" name="action" value="search" class="inline-flex items-center px-8 py-2 border
                                        border-transparent text-base font-medium rounded-md shadow-sm text-white
                                        {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700 focus:outline-none focus:ring-2
                                        focus:ring-offset-2 focus:ring-indigo-500">{{ __('Search') }}</button>
    <button type="submit" name="action" value="filter" class=" inline-flex items-center px-8 py-2 border
                                        border-transparent text-base font-medium rounded-md shadow-sm text-white
                                        {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700 focus:outline-none focus:ring-2
                                        focus:ring-offset-2 focus:ring-indigo-500">{{ __('Exact search') }}</button>

</div>
