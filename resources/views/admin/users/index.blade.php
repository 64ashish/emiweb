<x-admin-layout>
    <div class="px-4 sm:px-4 lg:px-4">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Users</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the users.</p>
            </div>
        </div>

        <div>
            @role('super admin')
            {!! Form::open(['route' => ['admin.users.search']])  !!}
            @endrole
            @hasanyrole('emiweb admin|emiweb staff')
            {!! Form::open(['route' => ['emiweb.users.search']])  !!}
            @endhasanyrole

            <div class="mt-4 sm:flex sm:items-center">
                <div class="w-full sm:max-w-xs mr-2">
                    <label for="email" class="sr-only">User Email</label>
                    <input type="text" name="email" id="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="users@example.com" value="{{ old('email') }}">
                </div>
                <button type="submit" class="mt-3 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Search Users</button>
            </div>

            </form>
        </div>

        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="shadow-sm ring-1 ring-black ring-opacity-5">
                        <table class="min-w-full border-separate" style="border-spacing: 0">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="w-24 sticky top-16 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">Name</th>
                                    <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell">Email</th>
                                    <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell">Created at</th>
                                    <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter lg:table-cell">Role</th>
                                    <th scope="col" class="sticky top-16  z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter">Organization</th>
                                    <th scope="col" class="sticky top-16  z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter">Last Login</th>
                                    <th scope="col" class="sticky top-16  z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                                        <span class="sr-only">Update</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($users as $user)
                                    <tr>
                                        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8 flex">
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
                                                <lord-icon
                                                        src="https://cdn.lordicon.com/giaigwkd.json"
                                                        trigger="loop"
                                                        colors="primary:#c71f16"
                                                        state="hover"
                                                        style="width:20px;height:20px">
                                                </lord-icon>
                                            @endif

                                        </td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500 hidden sm:table-cell">{{ $user->email}}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500 hidden sm:table-cell">{{ $user->created_at}}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500 hidden lg:table-cell">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500">
                                            @if($user->organization)
                                                {{ $user->organization->name }}
                                            @else
                                                No association
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500">
                                            @php
                                                $relativeTime = '';
                                                if ($user->latestLogin && isset($user->latestLogin->login_at)) {
                                                    $dateString = $user->latestLogin->login_at;
                                                    $date = \Carbon\Carbon::parse($dateString);
                                                    $now = \Carbon\Carbon::now();
                                                    $diffInMinutes = $now->diffInMinutes($date);
                                                    $diffInHours = $now->diffInHours($date);
                                                    $diffInDays = $now->diffInDays($date);
                                                    $diffInWeeks = $now->diffInWeeks($date);
                                                    $diffInMonths = $now->diffInMonths($date);
                                                    $diffInYears = $now->diffInYears($date);

                                                    if ($diffInYears > 0) {
                                                        $relativeTime = $diffInYears . ' year' . ($diffInYears > 1 ? 's' : '') . ' ago';
                                                    } elseif ($diffInMonths > 0) {
                                                        $relativeTime = $diffInMonths . ' month' . ($diffInMonths > 1 ? 's' : '') . ' ago';
                                                    } elseif ($diffInWeeks > 0) {
                                                        $relativeTime = $diffInWeeks . ' week' . ($diffInWeeks > 1 ? 's' : '') . ' ago';
                                                    } elseif ($diffInDays > 0) {
                                                        $relativeTime = $diffInDays . ' day' . ($diffInDays > 1 ? 's' : '') . ' ago';
                                                    } elseif ($diffInHours > 0) {
                                                        $relativeTime = $diffInHours . ' hour' . ($diffInHours > 1 ? 's' : '') . ' ago';
                                                    } elseif ($diffInMinutes > 0) {
                                                        $relativeTime = $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '') . ' ago';
                                                    } else {
                                                        $relativeTime = '';
                                                    }
                                                } else {
                                                    $relativeTime = '';
                                                }
                                                echo $relativeTime;
                                            @endphp
                                        </td>
                                        <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-6 lg:pr-8">
                                            @role('super admin')
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            @endrole
                                            @hasanyrole('emiweb admin|emiweb staff')
                                            <a href="{{ route('emiweb.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            @endhasanyrole
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- More people... -->
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
