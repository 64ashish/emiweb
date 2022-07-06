<x-app-layout>
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Collection name') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $ImageCollection->name }}</p>
            </div>

            <div class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 p-4">
                <ul class="grid grid-cols-3 gap-4">
                    @foreach($images as $image)
                    <li class="h-80">
                        <p>{{ $image }}</p>
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($image) }}" >
                    </li>
                    @endforeach
                </ul>
            </div>

            {!! Form::open([
                    'route' => ['ImageCollections.upload',  $ImageCollection  ],
                    'method' => 'post',
                    'files'=>true
                ],
                ['class' => 'space-y-8 a divide-y divide-gray-200'])
            !!}
            <dl class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 pb-4">

                <div class="sm:col-span-6 p-4">
                    <label for="cover-photo" class="block text-sm font-medium text-gray-700"> Cover photo </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="file-upload" name="images[]" type="file" multiple class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                </div>
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
</x-app-layout>
