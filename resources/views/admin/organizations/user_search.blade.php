<x-admin-layout>

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Search Results</h1>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="" class="inline-flex items-center justify-center rounded-md border
                border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700
                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add user</a>
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
                                backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">Name</th>
                                <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter sm:table-cell">Email</th>
                                <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter lg:table-cell">Role</th>
                                <th scope="col" class="sticky top-16  z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter">Organization</th>
                                <th scope="col" class="sticky top-16  z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                                    <span class="sr-only">Update</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                        {{ $user->name }}
                                        @if($user->is_admin)
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800"> Super Admin </span>
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
                                            No association
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                    text-right text-sm font-medium sm:pr-6 lg:pr-8">
{{--                                        {!! Form::post([]) !!}--}}
                                        @role('super admin')
                                        {!! Form::open(['route' => ['admin.organizations.users.sync', $organization, $user]], ['class' => 'inline-flex'])  !!}
                                        @endrole
                                        @hasanyrole('emiweb admin|emiweb staff')
                                        {!! Form::open(['route' => ['emiweb.organizations.users.sync', $organization, $user]], ['class' => 'inline-flex'])  !!}
                                        @endhasanyrole

                                        <button type="submit" value="attach" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <!-- Heroicon name: solid/mail -->


                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                            Link user
                                        </button>
                                        {!! Form::close() !!}


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
