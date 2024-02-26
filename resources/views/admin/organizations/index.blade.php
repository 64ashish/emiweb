<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Organizations</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the organizations in registered.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                @role('super admin')
                    <a href="{{ route('admin.organizations.create') }}" class="inline-flex items-center justify-center rounded-md border
                    border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add Organization</a>
               @endrole

                @hasanyrole('emiweb admin|emiweb staff')
                <a href="{{ route('emiweb.organizations.create') }}" class="inline-flex items-center justify-center rounded-md border
                    border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add Organization</a>
                @endhasanyrole

            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="shadow-sm ring-1 ring-black ring-opacity-5">
                        <table class="min-w-full border-separate" style="border-spacing: 0">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900
                                backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">Organization Name</th>
                                <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter sm:table-cell">Address</th>
                                <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter lg:table-cell">Phone</th>
                                <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter">Email</th>
                                <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($organizations as $organization)
                                <tr>
                                    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                        {{ $organization->name }}</td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500 hidden sm:table-cell">{{ $organization->address}}</td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500 hidden lg:table-cell">{{ $organization->phone }}</td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                    text-gray-500">{{ $organization->email }}</td>
                                    <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                    text-right text-sm font-medium sm:pr-6 lg:pr-8">
                                        @role('super admin')
                                            <a href="{{ route('admin.organizations.show', $organization) }}"
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm
                                                text-sm leading-4 font-medium rounded-md text-white bg-indigo-600
                                                hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                                focus:ring-indigo-500">View</a>
                                            <a href="{{ route('admin.organizations.edit', $organization) }}"
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm
                                                text-sm leading-4 font-medium rounded-md text-white bg-indigo-600
                                                hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                                focus:ring-indigo-500">Edit</a>
                                        @endrole

                                        @hasanyrole('emiweb admin|emiweb staff')
                                        <a href="{{ route('emiweb.organizations.show', $organization) }}"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm
                                                text-sm leading-4 font-medium rounded-md text-white bg-indigo-600
                                                hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                                focus:ring-indigo-500">View</a>
                                        <a href="{{ route('emiweb.organizations.edit', $organization) }}"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm
                                                text-sm leading-4 font-medium rounded-md text-white bg-indigo-600
                                                hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                                focus:ring-indigo-500">Edit</a>
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
