<x-admin-layout>

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">{{ __('Subscriptions Plans') }}</h1>
                <p class="mt-2 text-sm text-gray-700">{{ __('A list of all available plans') }}</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="" class="inline-flex items-center justify-center rounded-md border
                border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700
                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">{{ __('Add a plan') }}</a>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="shadow-sm ring-1 ring-black ring-opacity-5">
                        <table class="min-w-full border-separate" style="border-spacing: 0">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="sticky top-16 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900
                                backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">{{ __('Plan Name') }}</th>
                                    <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter sm:table-cell">{{ __('Cost') }}</th>
                                    <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter lg:table-cell">{{ __('API id') }}</th>
                                    <th scope="col" class="sticky top-16  z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter">{{ __('Subscribers') }}</th>
                                    <th scope="col" class="sticky top-16  z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                                        <span class="sr-only">{{ __('Update') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                    font-medium text-gray-900 sm:pl-6 lg:pl-8 flex">
                                        {{ $user->name }}
                                        @if($user->hasRole('organization admin'))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 ml-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                        @endif
                                        @if($user->hasRole('emiweb admin'))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 ml-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        @endif
                                        @if($user->hasRole('super admin'))
                                        <lord-icon src="https://cdn.lordicon.com/giaigwkd.json" trigger="loop" colors="primary:#c71f16" state="hover" style="width:20px;height:20px">
                                        </lord-icon>
                                        @endif

                                    </td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500 hidden sm:table-cell">{{ $user->email}}</td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500 hidden lg:table-cell">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500">
                                        @if($user->organization)
                                        {{ $user->organization->name }}
                                        @else
                                        {{ __(' No') }}
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                    text-right text-sm font-medium sm:pr-6 lg:pr-8">
                                        @role('super admin')
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                        @endrole
                                        @hasanyrole('emiweb admin|emiweb staff')
                                        <a href="{{ route('emiweb.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                        @endhasanyrole

                                    </td>
                                </tr>
                                @endforeach

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-admin-layout>