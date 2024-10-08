<div class="grid grid-cols-2 gap-x-6 gap-y-4">
@foreach($filterAttributes as $key => $filterAttribute)
        @if($filterAttribute === "---")
            <div class="col-span-2">
                <hr>
            </div>
        @elseif(
            $filterAttribute == ['birth_province','birth_parish']
            || $filterAttribute == ['birth_county','birth_parish']
            || $filterAttribute == ['from_province','from_parish']
            || $filterAttribute == ['to_province','to_parish']
            || $filterAttribute == ['to_county','to_parish']
            || $filterAttribute == ['emigration_province','emigration_parish']
            || $filterAttribute == ['home_county','home_parish']


        )
{{--            @dd($keywords[$filterAttribute[0]]??'null')--}}
{{--            <div class="col-span-2">--}}
{{--                <div x-data="loadCounties(--}}
{{--                    countyInit = '{{ $keywords[$filterAttribute[0]]??null }}',--}}
{{--                    parishInit = '{{ $keywords[$filterAttribute[1]]??null}}'--}}
{{--                        )"--}}
{{--                     x-cloak class="sm:grid sm:grid-cols-2 sm:items-start  gap-x-6">--}}
{{--                    <label for="{{ $filterAttribute[0] }}"--}}
{{--                           class=" text-sm font-medium text-gray-700 sm:mt-px sm:grid sm:grid-cols-3  sm:pt-2 gap-x-2 items-center">--}}
{{--                        {{ __(ucfirst(str_replace('_', ' ', $filterAttribute[0]))) }}:--}}
{{--                        <select x-model="county" name="{{ $filterAttribute[0] }}" class=" block w-full rounded-md border-gray-300--}}
{{--                                         py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none--}}
{{--                                          focus:ring-indigo-500 sm:text-sm col-span-2">--}}
{{--                            <option value="">-- {{ __('Select a province') }} --</option>--}}
{{--                            <template x-for="province in counties">--}}
{{--                                <option x-bind:value="province.county"--}}
{{--                                        x-bind:selected="province.county == '{{ $keywords[$filterAttribute[0]]??false }}'">--}}
{{--                                    <span x-text="province.county"></span>--}}
{{--                                </option>--}}
{{--                            </template>--}}
{{--                        </select>--}}
{{--                    </label>--}}

{{--                    <label x-bind:disabled="!county"  for="{{ $filterAttribute[1] }}"--}}
{{--                           class=" text-sm font-medium text-gray-700 sm:mt-px sm:grid sm:grid-cols-3  sm:pt-2 gap-x-2 items-center">{{ __(ucfirst(str_replace('_', ' ', $filterAttribute[1]))) }}:--}}
{{--                        <select x-model="parish" x-bind:disabled="!county" name="{{ $filterAttribute[1] }}" class="block w-full rounded-md border-gray-300--}}
{{--                                         py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none--}}
{{--                                          focus:ring-indigo-500 sm:text-sm col-span-2" >--}}
{{--                            <option value="">-- {{ __('Select a parish') }} --</option>--}}
{{--                            <template x-for="parishData in parishes">--}}
{{--                                <option :value="parishData"--}}
{{--                                        x-bind:selected="parishData == '{{ $keywords[$filterAttribute[1]]??false }}'"><span x-text="parishData"></span></option>--}}
{{--                            </template>--}}
{{--                        </select>--}}
{{--                    </label>--}}
{{--                </div>--}}

{{--            </div>--}}

{{--                        @dd($keywords[$filterAttribute[0]]??'null')--}}

                        <div class="col-span-2">
                            <div x-data="loadCounties(
                                countyInit = '{{ $keywords[$filterAttribute[0]]??null }}',
                                parishInit = '{{ $keywords[$filterAttribute[1]]??null}}'
                                    )"
                                 x-cloak class="sm:grid sm:grid-cols-2 sm:items-start  gap-x-6">
                                <label for="{{ $filterAttribute[0] }}"
                                       class=" text-sm font-medium text-gray-700 sm:mt-px sm:grid sm:grid-cols-3  sm:pt-2 gap-x-2 items-center">
                                    {{ __(ucfirst(str_replace('_', ' ', $filterAttribute[0]))) }}:

                                    <select x-model="county" name="{{ $filterAttribute[0] }}" class=" block w-full rounded-md border-gray-300
                                                     py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                                      focus:ring-indigo-500 sm:text-sm col-span-2">
                                        <option value="">-- {{ __('Select a province') }} --</option>
                                        <template x-for="province in counties">
                                            <option x-bind:value="province.county"
                                                    x-bind:selected="province.county == '{{ $keywords[$filterAttribute[0]]??false }}'">
                                                <span x-text="province.county"></span>
                                            </option>
                                        </template>
                                    </select>
                                </label>

                                <label  for="{{ $filterAttribute[1] }}"
                                       class=" text-sm font-medium text-gray-700 sm:mt-px sm:grid sm:grid-cols-3  sm:pt-2 gap-x-2 items-center">{{ __(ucfirst(str_replace('_', ' ', $filterAttribute[1]))) }}:
                                    <div class="mt-1 sm:mt-0 sm:col-span-2   flex gap-x-2">
                                        {!! Form::text($filterAttribute[1], null,
                                        ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                         sm:text-sm border-gray-300 rounded-md',
                                        'id' => $filterAttribute[1]]) !!}
                                    </div>

                                </label>
                            </div>

                        </div>


        @else
            <?php //pre($filterAttribute);  ?>
            <div class="sm:grid sm:grid-cols-3 sm:items-start">
                @if($filterAttribute == ['departure_year','departure_month','departure_day']
                    || $filterAttribute == ['birth_year','birth_month','birth_day']
                    || $filterAttribute == ['arrival_year','arrival_month','arrival_day']
                    || $filterAttribute == ['article_year','article_month','article_day'])
                    <label for="{{ $filterAttribute[0] }}"
                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                         {{ __(ucfirst(explode('_', trim($filterAttribute[0]))[0]). ' date') }}
                    </label>
                @else
                <label for="{{ $filterAttribute }}"
                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    @if($filterAttribute === "dob")
                        {{ __('Date of birth') }}
                    @else
                        {{ __(ucfirst(str_replace('_', ' ', $filterAttribute))) }}
                    @endif
                </label>
                @endif
                <div class="mt-1 sm:mt-0 sm:col-span-2  flex gap-x-2">
                    @if($filterAttribute == ['departure_year','departure_month','departure_day'] || $filterAttribute == ['birth_year','birth_month','birth_day'] || $filterAttribute == ['arrival_year','arrival_month','arrival_day']
                    || $filterAttribute == ['article_year','article_month','article_day'])
                        <div class="flex gap-2" >
                            {!! Form::text($filterAttribute[0], null,
                           ['class' => 'max-w-lg w-24 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                           sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                           'id' => $filterAttribute[0], 'x-mask' => "9999",'placeholder' => "YYYY"]) !!}

                            {!! Form::text($filterAttribute[1], null,
                           ['class' => 'max-w-lg block w-14  shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                           sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                           'id' => $filterAttribute[1], 'x-mask' => "99",'placeholder' => "MM"]) !!}
                            {!! Form::text($filterAttribute[2], null,
                           ['class' => 'max-w-lg w-14  block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                           sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                           'id' => $filterAttribute[2], 'x-mask' => "99",'placeholder' => "DD"]) !!}
                        </div>
                    @elseif(str_contains(str_replace('_', ' ', $filterAttribute), 'date') or $filterAttribute === "dob" or $filterAttribute === "traveled_on" or $filterAttribute === "age")
                        <div class="flex gap-2" x-data='{ compare: "{{ $keywords["compare_{$filterAttribute}"] ?? false }}" }'>
                            {!! Form::text("array_".$filterAttribute."[year]", null,
                           ['class' => 'max-w-lg w-24 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                           sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                           'id' => $filterAttribute."_year", 'x-mask' => "9999",'placeholder' => "YYYY",]) !!}
                            {!! Form::text("compare_".$filterAttribute, null,
                           ['class' => 'max-w-lg w-24 block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                           sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                           'id' => $filterAttribute."_year_compare", 'x-mask' => "9999",'placeholder' => "YYYY", 'x-show'=>"compare"]) !!}
                            {!! Form::text("array_".$filterAttribute."[month]", null,
                           ['class' => 'max-w-lg block w-14  shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                           sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                           'id' => $filterAttribute."_month", 'x-mask' => "99",'placeholder' => "MM",'x-show'=>"!compare"]) !!}
                            {!! Form::text("array_".$filterAttribute."[day]", null,
                           ['class' => 'max-w-lg w-14  block shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                           sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                           'id' => $filterAttribute."_day", 'x-mask' => "99",'placeholder' => "DD",'x-show'=>"!compare"]) !!}
                            <input type="checkbox" id="scales" name="compare_{{ $filterAttribute }}_check" x-model="compare" 
                            x-bind:value="compare" class="self-center rounded border-gray-300 ml-auto" {{ isset($keywords["compare_{$filterAttribute}"]) ? 'checked' : false }}>
                            <label for="scales"  x-model="compare" class="self-center  ml-auto" >{{ __('Interval') }}</label>
                        </div>
                    @elseif(in_array($filterAttribute, $enableQueryMatch))
                            {!! Form::text('qry_'.$filterAttribute.'[value]', null,
                                            ['class' => 'max-w-lg block w-2/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md',
                                            'id' => $filterAttribute.'_value']) !!}
                            {!! Form::select('qry_'.$filterAttribute.'[method]', [
                                         null => __('Contains'),
                                        'start' => __('Starting with'),
                                        'end' => __('Ending with'),
                                        'exact' => __('Exact')
                                        ], null,['class' => 'max-w-lg block w-1/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md','id' => 'qry_'.$filterAttribute]); !!}
                    @elseif($filterAttribute === 'from_province' and isset($provinces))
                        {!! Form::select($filterAttribute,
                                        $provinces,null,
                                        [
                                            'class' => 'mt-1 block w-full rounded-md border-gray-300
                                         py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                          focus:ring-indigo-500 sm:text-sm',
                                          'placeholder' => 'Select'
                                      ]) !!}
                    @elseif($filterAttribute === 'to_county' and isset($provinces))
                        {!! Form::select($filterAttribute,
                                        $provinces,null,
                                        [
                                            'class' => 'mt-1 block w-full rounded-md border-gray-300
                                         py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                          focus:ring-indigo-500 sm:text-sm',
                                          'placeholder' => 'Select'
                                      ]) !!}
                    @elseif($filterAttribute === 'gender' or $filterAttribute === 'sex')
                        {!! Form::select($filterAttribute,
                                        [
                                            null => 'Select',
                                            'M' => 'Man',
                                            'K' => 'Kvinna'
                                        ],null,
                                        [
                                            'class' => 'mt-1 block w-full rounded-md border-gray-300
                                         py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                          focus:ring-indigo-500 sm:text-sm',
                                          'placeholder' => 'Select'
                                      ]) !!}
                    @elseif($key === 'place' or $key === 'state')
                        {!! Form::text($key, null,
                                ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                 sm:text-sm border-gray-300 rounded-md',
                                'id' => $key]) !!}
                    @elseif($filterAttribute === 'emigration_county' or $filterAttribute === 'departure_county' or $filterAttribute === 'from_province' and isset($provincesCoun))
                        {!! Form::select($filterAttribute,$provincesCoun,null,['class' => 'mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm','placeholder' => 'Select' ]) !!}
                    @elseif($filterAttribute === 'county_in_sweden' and isset($provincesCoun))
                        {!! Form::select($filterAttribute,$provincesCoun,null,['class' => 'mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm','placeholder' => 'Select' ]) !!}
                    @elseif($filterAttribute === 'departure_port' and isset($provincesCoun))
                        <div class="flex gap-2" x-data='{ compare: "{{ $keywords["{$filterAttribute}_text"] ?? false }}" }'>
                            {!! Form::select($filterAttribute,$provincesCoun,null,['class' => 'max-w-lg block w-2/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md','placeholder' => 'Select','x-show'=>"!compare"]) !!}

                            {!! Form::text($filterAttribute.'_text', null,['class' => 'max-w-lg block w-2/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md','id' => $filterAttribute, 'x-show'=>"compare"]) !!}

                            <input type="checkbox" id="scales-text" name="compare_{{ $filterAttribute }}_check" x-model="compare" 
                            x-bind:value="compare" class="self-center rounded border-gray-300 ml-auto" {{ isset($keywords["{$filterAttribute}_text"]) ? 'checked' : false }}>
                            <label for="scales-text"  x-model="compare" class="self-center  ml-auto" >{{ __('Textbox') }}</label>
                        </div>
                    @else
                        {!! Form::text($filterAttribute, null,
                                ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                 sm:text-sm border-gray-300 rounded-md',
                                'id' => $filterAttribute]) !!}
                    @endif

                </div>
            </div>

        @endif

@endforeach

</div>

@if(count($advancedFields)>0)
    <div  x-data="{ expanded: false }">
        <a  @click="expanded = ! expanded" class="py-4 inline-flex items-center cursor-pointer text-lg mt-4 font-bold">

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
                @if($advancedField === "---")
                    <div class="col-span-2">
                        <hr>
                    </div>
                @else
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

                        @elseif($advancedField === 'from_province' and isset($provinces))
                            {!! Form::select($advancedField,
                                            $provinces,null,
                                            [
                                                'class' => 'mt-1 block w-full rounded-md border-gray-300
                                             py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                              focus:ring-indigo-500 sm:text-sm',
                                              'placeholder' => 'Select'
                                          ]) !!}
                        @elseif($advancedField === 'birth_province' and isset($provinces))
                            {!! Form::select($advancedField,
                                            $provinces,null,
                                            [
                                                'class' => 'mt-1 block w-full rounded-md border-gray-300
                                             py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                              focus:ring-indigo-500 sm:text-sm',
                                              'placeholder' => 'Select'
                                          ]) !!}
                        @elseif($advancedField === 'to_county' and isset($provinces))
                            {!! Form::select($advancedField,
                                            $provinces,null,
                                            [
                                                'class' => 'mt-1 block w-full rounded-md border-gray-300
                                             py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                              focus:ring-indigo-500 sm:text-sm',
                                              'placeholder' => 'Select'
                                          ]) !!}
                        @elseif($advancedField === 'gender' and isset($genders))
                            {!! Form::select($advancedField,
                                            $genders,null,
                                            [
                                                'class' => 'mt-1 block w-full rounded-md border-gray-300
                                             py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                              focus:ring-indigo-500 sm:text-sm',
                                              'placeholder' => 'Select'
                                          ]) !!}

                        @elseif(in_array($advancedField, $enableQueryMatch))
                                {!! Form::text('qry_'.$advancedField.'[value]', null,
                                                ['class' => 'max-w-lg block w-2/3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                 sm:text-sm border-gray-300 rounded-md',
                                                'id' => $advancedField.'_value']) !!}

                                {!! Form::select('qry_'.$advancedField.'[method]', [
                                            null => __('Contains'),
                                            'start' => __('Starting with'),
                                            'end' => __('Ending with'),
                                            'exact' => __('Exact')
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
                @endif

            @endforeach
        </div>

    </div>
@endif




<div class="sm:flex justify-end pt-4 gap-x-5">
    @if(Str::is('*search', Route::currentRoutename()) == true)
    <a href="{{ route('records', $archive_name->id) }}"  class="inline-flex items-center px-8 py-2  text-base font-mediumtext-base ">{{ __('Clear search fields') }}</a>
    @else
        <a href="{{ route('records', $archive->id) }}"  class="inline-flex items-center px-8 py-2  text-base font-mediumtext-base ">{{ __('Clear search fields') }}</a>
    @endif


    <button type="submit" name="action" value="filter" id="search-archive" class=" inline-flex items-center px-8 py-2 border
                                        border-transparent text-base font-medium rounded-md shadow-sm text-white
                                        {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700 focus:outline-none focus:ring-2
                                        focus:ring-offset-2 focus:ring-indigo-500">{{ __('Search') }}</button>

</div>

@if(isset($ProvincesParishes))
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('loadCounties', (countyInit = null, parishInit = null) => (
                {
                counties:getCounties(),
                county:countyInit,
                parish:parishInit,


                parishes() {

                   return getParishes(this.county)
                },


            }))
        });

        const getCounties = () => {
            return {!! $ProvincesParishes !!}
        }

        /*
        generates fake cities, later states have more values
        */
        const getParishes = (county) => {
            if(!county) return [];
            return getCounties().find(i => i.county === county).parish

        }
    </script>

@endif
