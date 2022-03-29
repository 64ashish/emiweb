<x-admin-layout>

    <form class="space-y-8 divide-y divide-gray-200"
          method="POST"
          action="{{ route('admin.categories.store') }}">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div>

                @csrf

                <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-5">
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Category name </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                 <input type="text" name="name" id="first-name" autocomplete="given-name" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                @error('name')
                                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                </p>@enderror

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                </div>
            </div>
        </div>
    </form>

</x-admin-layout>
