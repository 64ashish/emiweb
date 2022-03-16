<x-admin-layout>

    <form class="space-y-8 divide-y divide-gray-200"
          method="POST"
          action="{{ route('admin.roles.update', $role) }}">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div>

                @csrf
                @method('PUT')

                <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-5">
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Role name </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <input type="text" name="name" value="{{$role->name}}"
                                       id="first-name" autocomplete="given-name"
                                       class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                       sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                @error('name')
                                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-5 pb-5">
                <div class="flex justify-end">
                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                </div>
            </div>
        </div>
    </form>

            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="about" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Permissions Assigned to role</label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <ul>
                        @foreach($role->permissions as $rolePermission)
                            <li class="text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 flex space-x-3">
                                <span>{{ $rolePermission->name }}</span>
                                <form onsubmit="return confirm('Are you sure?')"
                                method="POST"
                                action="{{ route('admin.roles.permissions.revoke', [$role,$rolePermission]) }}"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>

                                </form>

                            </li>
                        @endforeach
                    </ul>


                </div>
            </div>






    <form class="space-y-8 divide-y divide-gray-200 mt-10"
          method="POST"
          action="{{ route('admin.roles.permissions', $role) }}">


        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
            <label for="permission" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Assign Permissions </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                @csrf
                <select id="permission" name="permission"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none
                        focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">

                    @foreach($permissions as $permission)
                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>

                    @endforeach
                </select>
            </div>
        </div>


        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <div class="pt-5">
                <div class="flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent
                    shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Assign Permission
                    </button>
                </div>
            </div>
        </div>
    </form>

</x-admin-layout>