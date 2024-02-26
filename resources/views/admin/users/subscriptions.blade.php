<x-admin-layout>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">users</h1>
                    <p class="mt-2 text-sm text-gray-700">A list of all the users.</p>
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
                                backdrop-filter lg:table-cell">Plan</th>
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
                                @foreach($subscriptions as $subscription)
{{--                                    @dd($subscription->users)--}}
                                    @if(!is_null($subscription->user))
                                        <tr>
                                        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                    font-medium text-gray-900 sm:pl-6 lg:pl-8 flex">
                                            {{ $subscription->user->name }}

                                        </td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500 hidden sm:table-cell">{{ $subscription->user->email}}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500 hidden lg:table-cell">
                                            {{ $subscription->name }}

                                        </td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500">
                                            @if($subscription->user->organization)
                                                {{ $subscription->user->organization->name }}
                                            @else
                                                No association
                                            @endif
                                        </td>
                                        <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                    text-right text-sm font-medium sm:pr-6 lg:pr-8">
                                            @role('super admin')
                                            <a href="{{ route('admin.users.edit', $subscription->user) }}" >View status</a>
                                            @endrole
                                            @hasanyrole('emiweb admin|emiweb staff')
                                            <a href="{{ route('emiweb.users.edit', $subscription->user) }}" class="text-indigo-600 hover:text-indigo-900">View Status</a>
                                            @endhasanyrole

                                        </td>
                                    </tr>
                                    @endif
                                @endforeach

                                @foreach($manualSubscriptions as $muser)
                                    {{--                                    @dd($subscription->users)--}}
                                    @if(!is_null($muser))
                                        <tr>
                                            <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                    font-medium text-gray-900 sm:pl-6 lg:pl-8 flex">
                                                {{ $muser->name }}

                                            </td>
                                            <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500 hidden sm:table-cell">{{ $muser->email}}</td>
                                            <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500 hidden lg:table-cell">
                                                @if($muser->organization)
                                                    {{ $muser->organization->name }}
                                                @else
                                                    Manual subscription
                                                @endif

                                            </td>
                                            <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500">
                                                No association
                                            </td>
                                            <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                    text-right text-sm font-medium sm:pr-6 lg:pr-8">
                                                @role('super admin')
                                                <a href="{{ route('admin.users.edit', $muser) }}" >View status</a>
                                                @endrole
                                                @hasanyrole('emiweb admin|emiweb staff')
                                                <a href="{{ route('emiweb.users.edit', $muser) }}" class="text-indigo-600 hover:text-indigo-900">View Status</a>
                                                @endhasanyrole

                                            </td>
                                        </tr>
                                    @endif
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
