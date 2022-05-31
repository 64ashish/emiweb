<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Archive name') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $archive->name }}</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">

                {!! Form::model($record,['route' => ['organizations.archives.record.update',$organization, $archive, $record], 'method' => 'put'],['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
                <dl class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 sm:grid-cols-2">
                    @foreach($fields as $field)

                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5 py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <label for="{{$field}}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ __(ucfirst(str_replace('_', ' ', $field))) }}</label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">

                                {!! Form::text($field, null,
                                        ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                        sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                        'id' => 'first_name']) !!}
                                @error($field)
                                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                </p>@enderror
                            </div>
                        </div>

                    @endforeach

                </dl>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent
                             shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                             focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create new record
                    </button>
                </div>
                {!! Form::close() !!}


            </div>
        </div>

    </div>
</x-app-layout>
