<div class="grid grid-cols-2 gap-4">
@foreach($filterAttributes as $filterAttribute)
    <div class="sm:grid sm:grid-cols-3 sm:items-start">
        <label for="{{ $filterAttribute }}"
               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            {{ __(ucfirst(str_replace('_', ' ', $filterAttribute))) }} </label>
        <div class="mt-1 sm:mt-0 sm:col-span-2">

            {!! Form::text($filterAttribute, null,
                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                    'id' => $filterAttribute]) !!}

        </div>
    </div>
@endforeach
</div>
<h4 class="py-4">Advanced Fields</h4>
<div class="grid grid-cols-2 gap-4">

@foreach($advancedFields as $advancedField)
    <div class="sm:grid sm:grid-cols-3 sm:items-start">
        <label for="{{ $advancedField }}"
               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            {{ __(ucfirst(str_replace('_', ' ', $advancedField))) }} </label>
        <div class="mt-1 sm:mt-0 sm:col-span-2">

            {!! Form::text($advancedField, null,
                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                    'id' => $advancedField]) !!}

        </div>
    </div>
@endforeach
</div>
