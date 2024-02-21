<x-admin-layout>
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section class="pt-6" aria-labelledby="section-1-title">

            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ isset($news) ? __('Edit News') : __('Add News') }}</h3>
                </div>
                <p class="text-left text-lg mt-4 font-bold text-gray-900 pb-4">

                </p>

                <!-- Create/Edit form -->
                <form action="{{ isset($news) ? route('admin.news.update', ['id' => $news->id]) : route('admin.news.store') }}" method="POST" novalidate>
                    @csrf
                    @if(isset($news))
                    @method('PUT')
                    @endif

                    <div class="py-4 sm:py-5  sm:gap-4 sm:px-6 flex items-top">
                        <label style="width: min(200px,100%);" class="text-sm font-medium text-gray-500 max-w-200" for="title">{{ __('Title') }}:</label>
                        <div class="mt-1 block w-full">
                            <input type="text" class="block w-full flex-shrink-0 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" name="title" value="{{ old('title', isset($news) ? $news->title : '') }}" maxlength="80" required>
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:gap-4 sm:px-6 flex items-top">
                        <label style="width: min(200px,100%);" class="text-sm font-medium text-gray-500 max-w-200" for="content">{{ __('Content') }}:</label>
                        <div class="mt-1 block w-full">
                            <textarea name="content" id="content" class="block w-full flex-shrink-0 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" rows="30" required>{{ old('content', isset($news) ? $news->content : '') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end py-4 sm:py-5 sm:gap-4 sm:px-6">
                        <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-sm">{{ isset($news) ? __('Update') : __('Create') }} {{ __('News') }}</button>
                    </div>
                </form>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>

                <script>
                    tinymce.init({
                        selector: 'textarea#content', // Replace this CSS selector to match the placeholder element for TinyMCE
                        plugins: 'powerpaste advcode table lists checklist emoticons',
                        toolbar: 'undo redo | blocks| bold italic | bullist numlist checklist | code | table',

                    });
                </script>
            </div>
        </section>
    </div>
</x-admin-layout>