<x-admin-layout>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">User Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">These are the user details.</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Full name</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->name }}</dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @foreach($user->roles as $role)
                            {{ $role->name }}
                        @endforeach
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Permissions</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @foreach($user->getAllPermissions() as $permission)
                            {{ $permission->name }},
                        @endforeach
                    </dd>
                </div>
            </dl>
        </div>
    </div>


    <div class="bg-white mt-5 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">User Role</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Update user role.</p>
        </div>
        {!! Form::model($user->roles,['route' =>['admin.users.sync-role', $user]]) !!}

        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">

            <fieldset>
                <legend class="sr-only">Roles</legend>
                <div class="space-y-5">
                    @foreach( $roles as $role)
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                {!! Form::radio('name', $role->name,
                                    in_array($role->name, $user->roles->pluck('name')->toArray())? 'true' : '',
                                     ['class' => 'focus:ring-indigo-500 h-4 w-4
                                    text-indigo-600 border-gray-300', 'id'=> $role->name]); !!}


                            </div>
                            <div class="ml-3 text-sm">
                                <label for="{{ $role->name }}" class="font-medium text-gray-700">{{ $role->name }}
                                </label>
                                <p id="small-description" class="text-gray-500">

                                    {{ $role->permissions->implode('name', ', ') }}
                                </p>
                            </div>
                        </div>
                    @endforeach


                </div>
            </fieldset>

        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm
                        text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent
                         shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                         focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
        </div>
            {!! Form::close() !!}

    </div>


</x-admin-layout>
