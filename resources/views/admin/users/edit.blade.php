<x-admin-layout>


        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div>

                @csrf
                @method('PUT')

                <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-5">
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">

                            <div class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                User's name: {{ $user->name }}
                            </div>

                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">

                            <div class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                Roles: {{ $user->roles->pluck('name') }}
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


</x-admin-layout>