<x-admin-layout>
    <div class="grid grid-cols-2 gap-x-5">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">User Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">These are the user details.</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0 ">
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

                    @role('super admin')
                        {!! Form::open(['route' =>['admin.users.update',$user], 'method' => 'put']) !!}
                    @endrole
                    @hasanyrole('emiweb admin|emiweb staff')
                        {!! Form::open(['route' =>['emiweb.users.update',$user], 'method' => 'put']) !!}
                    @endhasanyrole
                    @if(Auth::user()->id == $user->id)
                        <input type="hidden" name="is_password_update" value="1">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Current Password</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ Form::password('current_password', ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md','id' => 'password']) }}
                                @error('current_password')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                                @enderror
                            </dd>
                            <dt class="text-sm font-medium text-gray-500">New Password</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ Form::password('password', ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md', 'id' => 'password']) }}
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                                @enderror
                            </dd>
                        </div>
                    @endif  
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <input type="text" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" name="address" id="address" value="{{ isset($user->address) ? $user->address : '' }}">
                            @error('address')
                                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                            @enderror
                        </dd>
                        <dt class="text-sm font-medium text-gray-500">Post Code</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <input type="text" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" name="postcode" id="postcode" value="{{ isset($user->postcode) ? $user->postcode : '' }}">
                            @error('postcode')
                                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                            @enderror
                        </dd>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update Details</button>
                    </div>
                    {!! Form::close() !!}
                </dl>
            </div>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Subscription') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Below is the plan the user is subscribed to</p>
            </div>

            <div class="px-4 py-5 sm:px-6">
                @if(count($user->subscriptions()->active()->get()) > 0)
                    <ul>
                        @foreach($user->subscriptions()->active()->get() as $subscription)
                            <li>
                                <div class="mt-1 max-w-2xl text-sm text-gray-500 pb-2 text-center">
                                    Subscription plan: {{ $subscription->name }}
                                </div>

                                @if($subscription->ends_at)
                                    <div class="mt-1 max-w-2xl text-sm text-gray-500 pb-2 text-center">
                                    Your subscription ends on {{ $subscription->ends_at->format('Y.m.d') }}
                                    </div>
                                @else
                                    <div class="flex flex-col items-center">
                                        <div class="mt-1 max-w-2xl text-sm text-gray-500 pb-2">{{ __('Cancel subscription') }}</div>
                                        <a href="{{ route('emiweb.users.subscribers.cancel', $subscription->user) }}" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Cancel</a>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if($user->hasRole('subscriber') and (!is_null($user->manual_expire) and \Carbon\Carbon::parse($user->manual_expire)->greaterThanOrEqualTo(\Carbon\Carbon::now())))
                   <p class="mt-1 max-w-2xl text-sm text-gray-500 pb-2 text-center">
                       Manual subscription, expires on {{ $user->manual_expire->format('Y.m.d')  }} ({{$user->manual_expire->diffForHumans()}})
                   </p>
                @endif
            </div>
        </div>
    </div>
    {{-- @if(count($user->subscriptions()->active()->get()) > 0)
        <div class="bg-white mt-5 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">manually Plan Expiry</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Change user plan expiry.</p>
            </div>
            {!! Form::model($user->roles,['route' => ['admin.users.expire-plan', $user]]) !!}
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <fieldset>
                        <legend class="sr-only">Roles</legend>
                        <div class="space-y-5">
                            <label for="expiry_date">Select Date:</label>
                            {{ Form::date('expiry_date',null, ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md','id' => 'expiry_date','min' =>  date('Y-m-d')]) }}
                            @error('expiry_date')
                                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Change</button>
                </div>
            {!! Form::close() !!}
        </div>
    @endif --}}

    @can('syncRole', $user)
        <div class="bg-white mt-5 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">User Role</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Update user role.</p>
            </div>
            @role('super admin')
                {!! Form::model($user->roles,['route' =>['admin.users.sync-role', $user]]) !!}
            @endrole
            @hasanyrole('emiweb admin|emiweb staff')
                {!! Form::model($user->roles,['route' =>['emiweb.users.sync-role', $user]]) !!}
            @endhasanyrole


                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <fieldset>
                        <legend class="sr-only">Roles</legend>
                        <div class="space-y-5">
                            @foreach( $roles as $role)
                                <div class="relative flex items-start checkRole">
                                    <div class="flex items-center h-5">
                                        {!! Form::radio('name', $role->name, in_array($role->name, $user->roles->pluck('name')->toArray())? 'true' : '', ['class' => 'focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300', 'id'=> $role->name]); !!}
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="{{ $role->name }}" class="font-medium text-gray-700">{{ $role->name }}</label>
                                        <p id="small-description" class="text-gray-500">
                                            {{ $role->permissions->implode('name', ', ') }}
                                        </p>
                                    </div>
                                    @if($role->name == 'subscriber')
                                        <div class="ml-4">
                                            <input type="date" name="expiry_date" id="expiry_date" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" value="{{ isset($user->manual_expire) ? date('Y-m-d', strtotime($user->manual_expire)) : '' }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+1 year')) }}">

                                            {{-- {{ Form::date('expiry_date',null, ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md','id' => 'expiry_date','value' => date('Y-m-d', strtotime(Auth::user()->manual_expire)) ,'min' =>  date('Y-m-d')]) }} --}}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <a href="{{ route('admin.users.index') }}" type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                </div>
            {!! Form::close() !!}
        </div>
    @endcan

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $('.checkRole').on('click', function(){
            if($('#subscriber').is(':checked')){
                $('#expiry_date').css('display','flex');
            }else{
                $('#expiry_date').css('display','none');
            }
        });

        $( window ).on("load", function() {
            if($('#subscriber').is(':checked')){
                $('#expiry_date').css('display','flex');
            }else{
                $('#expiry_date').css('display','none');
            }
        });
    </script>
</x-admin-layout>
