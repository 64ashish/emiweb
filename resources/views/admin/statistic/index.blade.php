<x-admin-layout>

    @php 
        if(isset($_GET['sort']) && $_GET['sort'] != ''){
            $sort = $_GET['sort'];
            $sorted = explode('-',$sort);
        }
    @endphp

    @role('super admin')
        @php $role = 'admin'; @endphp
    @endrole
    @hasanyrole('emiweb admin|emiweb staff')
        @php $role = 'emiweb'; @endphp
    @endhasanyrole

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">User Statistics</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all user login history</p>
            </div>
        </div>

        <div>
            @role('super admin')
            {!! Form::open(['route' => ['admin.statistic.search']])  !!}
            @endrole
            @hasanyrole('emiweb admin|emiweb staff')
            {!! Form::open(['route' => ['emiweb.statistic.search']])  !!}
            @endhasanyrole

            <div class="mt-4 sm:flex sm:items-center">
                <div class="w-full sm:max-w-xs mr-2">
                    <label for="ip_address" class="sr-only">IP Address</label>
                    <input type="text" name="ip_address" id="ip_address" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="80.10.X.X" value="{{ isset($ip_address) ? $ip_address : '' }}">
                </div>
                <button type="submit" class="mt-3 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Search IP</button>
            </div>

            </form>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    <a href="{{ url($role . '/statistics' . (isset($sorted) && $sorted[1] == 'asc' && $sorted[0] == 'user' ? '?sort=user-desc' : '?sort=user-asc')) }}">
                                        Name
                                    </a>
                                </th>                                
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    <a href="{{ url($role . '/statistics' . (isset($sorted) && $sorted[1] == 'asc' && $sorted[0] == 'org' ? '?sort=org-desc' : '?sort=org-asc')) }}">
                                        Organization
                                    </a>
                                </th>                                
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    <a href="{{ url($role . '/statistics' . (isset($sorted) && $sorted[1] == 'asc' && $sorted[0] == 'ip' ? '?sort=ip-desc' : '?sort=ip-asc')) }}">
                                        IP Address
                                    </a>
                                </th>                                
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    <a href="{{ url($role . '/statistics' . (isset($sorted) && $sorted[1] == 'asc' && $sorted[0] == 'date' ? '?sort=date-desc' : '?sort=date-asc')) }}">
                                        Login Date
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @if(!empty($statistics) && count($statistics) > 0)
                                    @foreach($statistics as $statistic)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><a href="{{ route('admin.users.edit', $statistic->user) }}" class="text-indigo-600 hover:text-indigo-900">{{ $statistic->user->name }}</a></td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ isset($statistic->organization->name) ? $statistic->organization->name : '' }}</td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $statistic->ip_address }}</td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $statistic->login_at }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 text-center">No Result Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $statistics->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-admin-layout>