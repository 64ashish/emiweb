<x-app-layout>
    <div class="grid grid-cols-2 gap-x-5">
        <div class="col-span-2 lg:col-span-1 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('User information') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ __('These are the user details for your account') }}</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Full name') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->name }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Email') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
                    </div>
                    @if(auth()->user()->hasRole('organization admin | organization stuff'))
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
                    @endif

                    {!! Form::model($user,['route' =>['home.users.update',$user], 'method' => 'put']) !!}

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">

                        <dt class="text-sm font-medium text-gray-500">{{ __('Current password') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">

                            {{ Form::password('current_password', ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                'id' => 'password_old']) }}
                            @error('current_password')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </dd>
                        <dt class="text-sm font-medium text-gray-500">{{ __('New password') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ Form::password('password', ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                'id' => 'password']) }}
                            @error('password')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </dd>

                    </div>

                    <div class="px-4 py-3 text-right sm:px-6">
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent
                             shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                             focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Update password') }}</button>
                    </div>
                    {!! Form::close() !!}
                </dl>
            </div>
        </div>

        <div class="col-span-2 lg:col-span-1 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Subscription') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ __('Your plan is') }}:
                    @if($price == 1)
                        {{ __("1 Year") }}
                    @elseif($price == 2)
                        {{ __("3 Months") }}
                    @elseif(\Illuminate\Support\Facades\Auth::user()->hasRole('subscriber'))
                        {{ __("Manual payment (Swish, Invoice, Cash)") }}
                    @else
                        {{ __("Not subscribed") }}
                    @endif
                </p>

                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ __('Plan is valid until') }}:
                    @if($price == 1)
                        {{ \Carbon\Carbon::parse(Auth::user()->subscription('Regular Subscription')->created_at)->addMonths(12) }}
                    @elseif($price == 2)
                        {{ \Carbon\Carbon::parse(Auth::user()->subscription('3 Months')->created_at)->addMonths(3) }}
                    @elseif(\Illuminate\Support\Facades\Auth::user()->hasRole('subscriber'))
                        {{ \Carbon\Carbon::parse(Auth::user()->manual_expire) }}
                    @endif
                </p>
            </div>

            @if(\Illuminate\Support\Facades\Auth::user()->hasRole('subscriber') === false || \Carbon\Carbon::now()->addMonths(1)->gte(\Carbon\Carbon::parse(optional($user->subscriptions()->active()->first())->ends_at)))
                @if($user->subscriptions()->active()->first())
                    <div class="px-4 sm:px-6 mb-6">
                        <form action="/subscribe/{{ $user->subscriptions()->active()->first()->id }}/update"
                            method="post"
                            id="payment-form"
                            data-secret="{{ $intent->client_secret }}">
                            @csrf
                            <div class="form-row">
                                <div x-data="{ value: '{{ $user->subscriptions()->active()->first()->stripe_price }}' }"
                                    class="md:flex md:justify-center md:space-x-6 my-8" >
                                    <div class="flex items-center space-x-3 rounded-md shadow-lg px-3 lg:px-6"
                                        x-bind:class="value == '{{ config('services.subscription.3_months') }}' ? 'border border-solid border-indigo-500 shadow-indigo-300/50' : 'shadow-gray-300/50 border border-solid '"
                                    >
                                        <label for="standard" class="flex items-center gap-2">
                                            <input type="radio" name="plan" id="standard"
                                                value="{{ config('services.subscription.3_months') }}" x-model="value"
                                                checked="{{ $user->subscriptions()->active()->first()->stripe_price == config('services.subscription.3_months') ? 'checked':'' }}">
                                            <div class="font-bold text-gray-900 pr-6 flex flex-col justify-center">
                                                <div class="mt-6">
                                                    <span class="text-2xl lg:text-3xl">200</span>
                                                    <span class="text-lg lg:text-xl">SEK</span>
                                                    <span class="font-medium">/3 {{__('months')}}</span>
                                                </div>

                                                <div class="text-sm text-gray-500 font-medium pt-2 mb-6">
                                                    <p>{{ __('Renews at 200 SEK /months') }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="flex items-center space-x-3 rounded-md shadow-lg px-3 lg:px-6"
                                        x-bind:class="value == '{{ config('services.subscription.1_year') }}' ? 'border border-solid border-indigo-500 shadow-indigo-300/50' : 'shadow-gray-300/50 border border-solid '"
                                    >
                                        <label for="premium" class="flex items-center gap-2">
                                            <input type="radio" name="plan" id="premium"
                                                value="{{ config('services.subscription.1_year') }}" x-model="value"
                                                checked="{{ $user->subscriptions()->active()->first()->stripe_price == config('services.subscription.1_year')?'checked':'' }}">
                                            <div class="font-bold text-gray-900 pr-6  flex flex-col">
                                                <div class="mt-6">
                                                    <span class="text-2xl lg:text-3xl">600</span>
                                                    <span class="text-lg lg:text-xl">SEK</span>
                                                    <span class="font-medium">/{{__('year')}}</span>
                                                </div>

                                                <div class="text-sm text-gray-500 font-medium pt-2 mb-6">
                                                    <p>{{ __('Renews at 350 SEK /year') }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="pt-8 flex items-center justify-center">
                                    <button id="card-button" class="inline-flex justify-center py-2 px-4 border border-transparent
                                    shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                                    focus:outline-none">
                                        {{__('Change subscription')}}
                                    </button>
                                </div>
                                </div>


                        </form>
                    </div>
                    <div class="border-t border-gray-200  px-4 py-5 ">
                        @if($user->subscriptions()->active()->first()->ends_at)
                        Your subscription ends on {{ $user->subscriptions()->active()->first()->ends_at->format('Y.m.d') }}
                        @else
                            <div class="flex flex-col items-center">
                                <div class="mt-1 max-w-2xl text-sm text-gray-500 pb-2">{{ __('Cancel subscription') }}</div>
                                <a href="{{ route('subscribe.cancel') }}" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent
                                    shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700
                                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    {{ __('Cancel') }}
                                </a>
                            </div>

                        @endif

                    </div>
                @else
                    @php $new_style = ''; @endphp
                    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('subscriber') && $price != 1 && $price != 2 && Auth::user()->manual_expire != '')
                        @php
                            $userManualExpireDate = \Carbon\Carbon::parse(Auth::user()->manual_expire);
                            $currentDate = \Carbon\Carbon::now();
                            
                            $oneWeekFromNow = $currentDate->copy()->addDays(3);
                            
                            if ($userManualExpireDate->greaterThan($oneWeekFromNow)) {
                                $new_style = 'style="display: none;"';
                            }
                        @endphp
                    @endif
                    <div class="px-4 sm:px-6" <?= $new_style ?>>

                        <form action="/subscribe" method="post" id="payment-form" data-secret="{{ $intent->client_secret }}">
                            @csrf
                            <div class="form-row">
                                <div x-data="{value:null}"
                                    class="md:flex md:justify-center md:space-x-6 my-8" >
                                    <div class="flex items-center space-x-3 rounded-md shadow-lg px-3 lg:px-6"  x-bind:class="value == '{{ config('services.subscription.3_months') }}' ? 'border border-solid border-indigo-500 shadow-indigo-300/50' : 'shadow-gray-300/50 border border-solid '" >
                                        <label for="standard" class="flex items-center gap-2">
                                            <input type="radio" name="plan" id="standard"
                                                value="{{ config('services.subscription.3_months') }}" onclick="getPlanId('{{ config('services.subscription.3_months') }}','3')" x-model="value" checked="">
                                            <div class="font-bold text-gray-900 pr-6 flex flex-col justify-center">
                                                <div class="mt-6">
                                                    <span class="text-2xl lg:text-3xl">200</span>
                                                    <span class="text-lg lg:text-xl">SEK</span>
                                                    <span class="font-medium">/3 {{__('months')}}</span>
                                                </div>

                                                <div class="text-sm text-gray-500 font-medium pt-2 mb-6">
                                                    <p>{{ __('Renews at 200 SEK /months') }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="flex items-center space-x-3 rounded-md shadow-lg px-3 lg:px-6" x-bind:class="value == '{{ config('services.subscription.1_year') }}' ? 'border border-solid border-indigo-500 shadow-indigo-300/50' : 'shadow-gray-300/50 border border-solid '" >
                                        <label for="premium" class="flex items-center gap-2">
                                            <input type="radio" name="plan" id="premium"
                                                value="{{ config('services.subscription.1_year') }}" onclick="getPlanId('{{ config('services.subscription.1_year') }}','1')" x-model="value">
                                            <div class="font-bold text-gray-900 pr-6  flex flex-col">
                                                <div class="mt-6">
                                                    <span class="text-2xl lg:text-3xl">600</span>
                                                    <span class="text-lg lg:text-xl">SEK</span>
                                                    <span class="font-medium">/{{__('year')}}</span>
                                                </div>

                                                <div class="text-sm text-gray-500 font-medium pt-2 mb-6">
                                                    <p>{{ __('Renews at 350 SEK /year') }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex flex-col space-x-6 pr-4 mb-5">
                                    <label for="cardholder-name" class="py-2 px-3 pl-6 text-gray-500 font-medium">{{ __('Discount coupon') }}</label>
                                    <div class="flex">
                                        <input type="text" id="coupon" class="placeholder:text-gray-500 block w-full border border-gray-300 rounded-md py-2 pr-4 px-1 shadow-sm focus:outline-none focus:border-indigo-500 focus:placeholder:text-transparent focus:ring-1 sm:text-sm" value="">
                                        <button type="button" id="redeem" class="py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                                        focus:outline-none"> {{ __('Redeem') }} </button>
                                    </div>
                                    <p class="ml-2" id="coupon-error"></p>
                                </div>

                                <div class="flex flex-col  space-x-6 pr-8 mb-5">
                                    <label for="cardholder-name" class="py-2 px-3 pl-6 text-gray-500 font-medium">Cardholder's Name</label>
                                    <input type="text" id="cardholder-name" class="placeholder:text-gray-500 block w-full border border-gray-300 rounded-md py-2
                                    px-3 shadow-sm focus:outline-none focus:border-indigo-500 focus:placeholder:text-transparent focus:ring-1 sm:text-sm">
                                </div>
                                <div class="max-w-lg mx-auto rounded-md shadow-md shadow-gray-300/50 p-6 mb-8">
                                    <label for="card-element">
                                        <div class="flex items-center space-x-3 mb-4">
                                            <div class="flex-none w-16 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                {{-- Visa logo --}}
                                                <svg width="48" height="16" viewBox="0 0 48 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20.7999 15.3105H16.9116L19.3436 0.272583H23.2318L20.7999 15.3105Z" fill="#00579F"/>
                                                    <path d="M34.8955 0.640163C34.1286 0.335892 32.9121 -6.10352e-05 31.408 -6.10352e-05C27.5681 -6.10352e-05 24.8641 2.04755 24.8475 4.97502C24.8156 7.1349 26.7835 8.33454 28.2553 9.05472C29.7597 9.79062 30.2711 10.271 30.2711 10.9269C30.2557 11.9343 29.0555 12.3987 27.936 12.3987C26.3836 12.3987 25.5518 12.1593 24.2877 11.5988L23.7757 11.3585L23.2316 14.7342C24.1435 15.1497 25.8237 15.5184 27.5681 15.5346C31.648 15.5346 34.3042 13.5186 34.3357 10.399C34.3512 8.68708 33.3121 7.37538 31.0718 6.30352C29.7118 5.61545 28.879 5.1515 28.879 4.44749C28.8949 3.80747 29.5834 3.15194 31.1186 3.15194C32.3827 3.11983 33.3114 3.42368 34.015 3.72774L34.3667 3.88742L34.8955 0.640163V0.640163Z" fill="#00579F"/>
                                                    <path d="M40.0634 9.98311C40.3837 9.1192 41.6158 5.77562 41.6158 5.77562C41.5997 5.80772 41.9354 4.89576 42.1274 4.33591L42.3992 5.63167C42.3992 5.63167 43.1355 9.23125 43.2954 9.98311C42.6877 9.98311 40.8315 9.98311 40.0634 9.98311ZM44.8631 0.272583H41.8555C40.928 0.272583 40.2233 0.544322 39.8232 1.52029L34.0475 15.3103H38.1275C38.1275 15.3103 38.7992 13.4543 38.9435 13.0545C39.3911 13.0545 43.36 13.0545 43.9358 13.0545C44.0475 13.5825 44.3998 15.3103 44.3998 15.3103H48L44.8631 0.272583V0.272583Z" fill="#00579F"/>
                                                    <path d="M13.6639 0.272583L9.85596 10.527L9.43985 8.44729C8.73583 6.04757 6.5279 3.44032 4.06396 2.14392L7.55192 15.2946H11.6637L17.7755 0.272583H13.6639V0.272583Z" fill="#00579F"/>
                                                    <path d="M6.31995 0.272583H0.0640008L0 0.576429C4.88003 1.82434 8.11198 4.8324 9.43985 8.44793L8.07988 1.53666C7.85598 0.576216 7.16791 0.304265 6.31995 0.272583Z" fill="#FAA61A"/>
                                                </svg>
                                            </div>
                                            <div class="flex-none w-16 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                {{-- mastercard logo --}}
                                                <svg width="31" height="24" viewBox="0 0 31 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_76_9)">
                                                        <path d="M5.60103 23.9474V22.3547C5.60103 21.7454 5.2299 21.3464 4.59278 21.3464C4.27423 21.3464 3.92784 21.4516 3.68969 21.798C3.50412 21.5072 3.23815 21.3464 2.83918 21.3464C2.5732 21.3464 2.30722 21.4268 2.09691 21.7176V21.399H1.54021V23.9474H2.09691V22.5402C2.09691 22.0887 2.33505 21.8753 2.70619 21.8753C3.07732 21.8753 3.26289 22.1134 3.26289 22.5402V23.9474H3.81959V22.5402C3.81959 22.0887 4.08557 21.8753 4.42887 21.8753C4.8 21.8753 4.98557 22.1134 4.98557 22.5402V23.9474H5.60103ZM13.8588 21.399H12.9557V20.6289H12.399V21.399H11.8948V21.9031H12.399V23.0722C12.399 23.6567 12.6371 24 13.2742 24C13.5124 24 13.7784 23.9196 13.9639 23.8145L13.8031 23.3351C13.6423 23.4402 13.4567 23.4681 13.3237 23.4681C13.0577 23.4681 12.9526 23.3072 12.9526 23.0444V21.9031H13.8557V21.399H13.8588ZM18.5845 21.3433C18.266 21.3433 18.0526 21.5041 17.9196 21.7145V21.3959H17.3629V23.9444H17.9196V22.5093C17.9196 22.0856 18.1052 21.8444 18.4515 21.8444C18.5567 21.8444 18.6897 21.8722 18.7979 21.8969L18.9588 21.365C18.8474 21.3433 18.6897 21.3433 18.5845 21.3433ZM11.4433 21.6093C11.1773 21.4237 10.8062 21.3433 10.4072 21.3433C9.7701 21.3433 9.34639 21.6619 9.34639 22.166C9.34639 22.5897 9.66495 22.831 10.2217 22.9083L10.4876 22.9361C10.7784 22.9887 10.9392 23.0691 10.9392 23.2021C10.9392 23.3877 10.7258 23.5206 10.3546 23.5206C9.98351 23.5206 9.68969 23.3877 9.50412 23.2547L9.23815 23.6784C9.52887 23.8918 9.92784 23.9969 10.3268 23.9969C11.0691 23.9969 11.4959 23.6505 11.4959 23.1743C11.4959 22.7227 11.1495 22.4846 10.6206 22.4042L10.3546 22.3763C10.1165 22.3485 9.93093 22.2959 9.93093 22.1382C9.93093 21.9526 10.1165 21.8474 10.4103 21.8474C10.7289 21.8474 11.0474 21.9804 11.2082 22.0609L11.4433 21.6093ZM26.2546 21.3433C25.9361 21.3433 25.7227 21.5041 25.5897 21.7145V21.3959H25.033V23.9444H25.5897V22.5093C25.5897 22.0856 25.7753 21.8444 26.1216 21.8444C26.2268 21.8444 26.3598 21.8722 26.468 21.8969L26.6289 21.3712C26.5206 21.3433 26.3629 21.3433 26.2546 21.3433ZM19.1412 22.6732C19.1412 23.4433 19.6732 24 20.4959 24C20.867 24 21.133 23.9196 21.399 23.7093L21.133 23.2578C20.9196 23.4186 20.7093 23.4959 20.468 23.4959C20.0165 23.4959 19.6979 23.1773 19.6979 22.6732C19.6979 22.1938 20.0165 21.8753 20.468 21.8505C20.7062 21.8505 20.9196 21.931 21.133 22.0887L21.399 21.6371C21.133 21.4237 20.867 21.3464 20.4959 21.3464C19.6732 21.3433 19.1412 21.9031 19.1412 22.6732ZM24.2907 22.6732V21.399H23.734V21.7176C23.5485 21.4794 23.2825 21.3464 22.9361 21.3464C22.2186 21.3464 21.6619 21.9031 21.6619 22.6732C21.6619 23.4433 22.2186 24 22.9361 24C23.3072 24 23.5732 23.867 23.734 23.6289V23.9474H24.2907V22.6732ZM22.2464 22.6732C22.2464 22.2217 22.5371 21.8505 23.0165 21.8505C23.468 21.8505 23.7866 22.1969 23.7866 22.6732C23.7866 23.1248 23.468 23.4959 23.0165 23.4959C22.5402 23.4681 22.2464 23.1217 22.2464 22.6732ZM15.5845 21.3433C14.8423 21.3433 14.3103 21.8753 14.3103 22.6701C14.3103 23.4681 14.8423 23.9969 15.6124 23.9969C15.9835 23.9969 16.3546 23.8918 16.6485 23.6505L16.3825 23.2516C16.1691 23.4124 15.9031 23.5176 15.6402 23.5176C15.2938 23.5176 14.9505 23.3567 14.8701 22.9083H16.7536C16.7536 22.8279 16.7536 22.7753 16.7536 22.6949C16.7784 21.8753 16.299 21.3433 15.5845 21.3433ZM15.5845 21.8227C15.9309 21.8227 16.1691 22.0361 16.2217 22.432H14.8948C14.9474 22.0887 15.1856 21.8227 15.5845 21.8227ZM29.4155 22.6732V20.3907H28.8588V21.7176C28.6732 21.4794 28.4072 21.3464 28.0608 21.3464C27.3433 21.3464 26.7866 21.9031 26.7866 22.6732C26.7866 23.4433 27.3433 24 28.0608 24C28.432 24 28.6979 23.867 28.8588 23.6289V23.9474H29.4155V22.6732ZM27.3711 22.6732C27.3711 22.2217 27.6619 21.8505 28.1412 21.8505C28.5928 21.8505 28.9113 22.1969 28.9113 22.6732C28.9113 23.1248 28.5928 23.4959 28.1412 23.4959C27.6619 23.4681 27.3711 23.1217 27.3711 22.6732ZM8.73402 22.6732V21.399H8.17732V21.7176C7.99175 21.4794 7.72577 21.3464 7.37938 21.3464C6.66186 21.3464 6.10516 21.9031 6.10516 22.6732C6.10516 23.4433 6.66186 24 7.37938 24C7.75052 24 8.0165 23.867 8.17732 23.6289V23.9474H8.73402V22.6732ZM6.66495 22.6732C6.66495 22.2217 6.95567 21.8505 7.43505 21.8505C7.8866 21.8505 8.20515 22.1969 8.20515 22.6732C8.20515 23.1248 7.8866 23.4959 7.43505 23.4959C6.95567 23.4681 6.66495 23.1217 6.66495 22.6732Z" fill="black"/>
                                                        <path d="M19.6206 2.04431H11.2577V17.0691H19.6206V2.04431Z" fill="#FF5A00"/>
                                                        <path d="M11.8144 9.5567C11.8144 6.50412 13.2495 3.79485 15.4515 2.04433C13.8309 0.770103 11.7866 0 9.5567 0C4.27423 0 0 4.27423 0 9.5567C0 14.8392 4.27423 19.1134 9.5567 19.1134C11.7866 19.1134 13.8309 18.3433 15.4515 17.0691C13.2464 15.3433 11.8144 12.6093 11.8144 9.5567Z" fill="#EB001B"/>
                                                        <path d="M30.9031 9.5567C30.9031 14.8392 26.6289 19.1134 21.3464 19.1134C19.1165 19.1134 17.0722 18.3433 15.4515 17.0691C17.6814 15.3155 19.0887 12.6093 19.0887 9.5567C19.0887 6.50412 17.6536 3.79485 15.4515 2.04433C17.0691 0.770103 19.1134 0 21.3433 0C26.6289 0 30.9031 4.30206 30.9031 9.5567Z" fill="#F79E1B"/>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_76_9">
                                                            <rect width="30.9031" height="24" fill="white"/>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <div class="flex-none w-16 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                {{-- american express logo --}}
                                                <svg width="48" height="19" viewBox="0 0 48 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.29472 18.3648V10.8475H17.2541L18.1081 11.9608L18.9902 10.8475H47.8808V17.8464C47.8808 17.8464 47.1253 18.3573 46.2514 18.3648H30.2542L29.2913 17.1798V18.3648H26.1363V16.342C26.1363 16.342 25.7053 16.6243 24.7736 16.6243H23.6997V18.3648H18.9227L18.07 17.2277L17.2042 18.3648H9.29472Z" fill="white"/>
                                                    <path d="M0 5.18179L1.79487 0.997314H4.89891L5.91752 3.34129V0.997314H9.77613L10.3825 2.69146L10.9704 0.997314H28.2915V1.84902C28.2915 1.84902 29.2021 0.997314 30.6985 0.997314L36.3186 1.01696L37.3196 3.33025V0.997314H40.5487L41.4375 2.32612V0.997314H44.6962V8.51456H41.4375L40.5857 7.18145V8.51456H35.8415L35.3644 7.32957H34.089L33.6197 8.51456H30.4023C29.1146 8.51456 28.2915 7.68024 28.2915 7.68024V8.51456H23.4405L22.4777 7.32957V8.51456H4.43907L3.96229 7.32957H2.69095L2.21755 8.51456H0V5.18179Z" fill="white"/>
                                                    <path d="M2.43015 1.92407L0.00926208 7.55275H1.58539L2.03207 6.42563H4.62885L5.07322 7.55275H6.68406L4.26549 1.92407H2.43015ZM3.32583 3.23404L4.11737 5.20362H2.53198L3.32583 3.23404V3.23404Z" fill="#016FD0"/>
                                                    <path d="M6.85069 7.55178V1.9231L9.09045 1.93142L10.3932 5.56043L11.6647 1.9231H13.8865V7.55178H12.4794V3.40433L10.9877 7.55178H9.75365L8.25786 3.40433V7.55178H6.85069Z" fill="#016FD0"/>
                                                    <path d="M14.8493 7.55178V1.9231H19.4412V3.18215H16.2713V4.14494H19.3671V5.32993H16.2713V6.32976H19.4412V7.55178H14.8493Z" fill="#016FD0"/>
                                                    <path d="M20.2558 1.92407V7.55275H21.663V5.55309H22.2555L23.9427 7.55275H25.6623L23.8108 5.47903C24.5707 5.41491 25.3545 4.76271 25.3545 3.75016C25.3545 2.56569 24.4248 1.92407 23.3873 1.92407H20.2558V1.92407ZM21.663 3.18312H23.2715C23.6574 3.18312 23.9381 3.48495 23.9381 3.77561C23.9381 4.14956 23.5744 4.36811 23.2924 4.36811H21.663V3.18312V3.18312Z" fill="#016FD0"/>
                                                    <path d="M27.3657 7.55178H25.929V1.9231H27.3657V7.55178Z" fill="#016FD0"/>
                                                    <path d="M30.7726 7.55178H30.4624C28.9619 7.55178 28.0508 6.36957 28.0508 4.76058C28.0508 3.11184 28.9517 1.9231 30.8466 1.9231H32.4019V3.2562H30.7898C30.0205 3.2562 29.4765 3.85652 29.4765 4.77447C29.4765 5.86453 30.0986 6.32236 30.9948 6.32236H31.3651L30.7726 7.55178Z" fill="#016FD0"/>
                                                    <path d="M33.8346 1.92407L31.4137 7.55275H32.9898L33.4365 6.42563H36.0333L36.4776 7.55275H38.0885L35.6699 1.92407H33.8346ZM34.7303 3.23404L35.5218 5.20362H33.9364L34.7303 3.23404Z" fill="#016FD0"/>
                                                    <path d="M38.2528 7.55178V1.9231H40.0419L42.3262 5.45954V1.9231H43.7334V7.55178H42.0022L39.66 3.92276V7.55178H38.2528Z" fill="#016FD0"/>
                                                    <path d="M10.2575 17.402V11.7733H14.8493V13.0324H11.6795V13.9952H14.7753V15.1801H11.6795V16.18H14.8493V17.402H10.2575Z" fill="#016FD0"/>
                                                    <path d="M32.7574 17.402V11.7733H37.3492V13.0324H34.1794V13.9952H37.2604V15.1801H34.1794V16.18H37.3492V17.402H32.7574Z" fill="#016FD0"/>
                                                    <path d="M15.0276 17.402L17.2633 14.6224L14.9743 11.7733H16.7472L18.1104 13.5346L19.4782 11.7733H21.1816L18.9227 14.5877L21.1626 17.402H19.39L18.0664 15.6685L16.7749 17.402H15.0276Z" fill="#016FD0"/>
                                                    <path d="M21.3297 11.7743V17.403H22.7739V15.6255H24.2552C25.5085 15.6255 26.4585 14.9606 26.4585 13.6675C26.4585 12.5963 25.7134 11.7743 24.438 11.7743H21.3297V11.7743ZM22.7739 13.0472H24.3338C24.7388 13.0472 25.0282 13.2954 25.0282 13.6953C25.0282 14.0709 24.7402 14.3433 24.3292 14.3433H22.7739V13.0472Z" fill="#016FD0"/>
                                                    <path d="M27.0695 11.7733V17.402H28.4767V15.4023H29.0692L30.7564 17.402H32.476L30.6245 15.3283C31.3843 15.2641 32.1682 14.612 32.1682 13.5994C32.1682 12.4149 31.2385 11.7733 30.2009 11.7733H27.0695V11.7733ZM28.4767 13.0324H30.0852C30.4711 13.0324 30.7518 13.3342 30.7518 13.6249C30.7518 13.9988 30.3881 14.2173 30.106 14.2173H28.4767V13.0324V13.0324Z" fill="#016FD0"/>
                                                    <path d="M38.001 17.402V16.18H40.8172C41.2339 16.18 41.4143 15.9548 41.4143 15.7078C41.4143 15.4712 41.2345 15.232 40.8172 15.232H39.5446C38.4384 15.232 37.8223 14.558 37.8223 13.5462C37.8223 12.6437 38.3865 11.7733 40.0303 11.7733H42.7706L42.1781 13.0398H39.8081C39.3551 13.0398 39.2156 13.2775 39.2156 13.5045C39.2156 13.7378 39.3879 13.9952 39.734 13.9952H41.0671C42.3003 13.9952 42.8354 14.6946 42.8354 15.6106C42.8354 16.5954 42.2391 17.402 41 17.402H38.001Z" fill="#016FD0"/>
                                                    <path d="M43.1656 17.402V16.18H45.9818C46.3985 16.18 46.5789 15.9548 46.5789 15.7078C46.5789 15.4712 46.3991 15.232 45.9818 15.232H44.7092C43.603 15.232 42.987 14.558 42.987 13.5462C42.987 12.6437 43.5511 11.7733 45.1949 11.7733H47.9352L47.3427 13.0398H44.9727C44.5197 13.0398 44.3802 13.2775 44.3802 13.5045C44.3802 13.7378 44.5526 13.9952 44.8987 13.9952H46.2318C47.4649 13.9952 48 14.6946 48 15.6106C48 16.5954 47.4037 17.402 46.1646 17.402H43.1656Z" fill="#016FD0"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </label>
                                    <div id="card-element" class="border border-solid border-gray-300 rounded-md h-9 relative pt-2 pl-4">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>

                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>

                                    <div class="pt-8 flex items-center justify-center">
                                        <button id="card-button" class="inline-flex justify-center py-2 px-4 border border-transparent
                                    shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                                    focus:outline-none subscribe-new">
                                            {{ __('Subscribe') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                        {!! Form::close() !!}
                            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
                            <script>
                                const stripe = Stripe('{{ env('STRIPE_KEY') }}');

                                var elements = stripe.elements();
                                var redeem = document.getElementById('redeem');
                                var couponData = '';
                                redeem.onclick = async function() {
                                    var couponData = document.getElementById('coupon').value;

                                    const sessionId = await createPaymentSession(couponData);
                                };

                                async function createPaymentSession(couponCode) {
                                    $('#coupon-error').html('');
                                    if(couponCode != '' && $('.remove-coupon').length != 1){
                                        try {
                                            const response = await fetch('/checkCoupon', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                },
                                                body: JSON.stringify({
                                                    "_token": "{{ csrf_token() }}",
                                                    couponCode: couponCode,
                                                }),
                                            });

                                            const data = await response.json();
                                            if (data.error) {
                                                throw new Error(data.error);
                                            }
                                            if(data.status == 'true'){
                                                $('#redeem').html('{{ __("Remove") }}').addClass('remove-coupon');
                                                $('.remove-coupon').attr('id','');
                                                $('#coupon').attr('disabled','disabled');
                                                $('#coupon-error').html('{{ __("Coupon Applied Successfully") }}').attr( "style","color: black");
                                                setTimeout(() => {
                                                    $('#coupon-error').html('');
                                                }, 1000);
                                                couponCode = data.id;
                                            }
                                            if(data.status == 'false'){
                                                $('#coupon-error').html(data.message).attr( "style","color: red");
                                                couponCode = '';
                                            }
                                            return data.sessionId;
                                        } catch (error) {
                                            console.error(error);
                                            return null;
                                        }
                                    }else if($('.remove-coupon').length == 1){
                                        $('.remove-coupon').html('{{ __("Redeem") }}').attr('id','redeem').removeClass('remove-coupon');
                                        $('#coupon').removeAttr('disabled').val('');
                                        couponCode = '';
                                    }
                                }

                                // (Note that this demo uses a wider set of styles than the guide below.)
                                var style = {
                                    base: {
                                        color: '#32325d',
                                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                        fontSmoothing: 'antialiased',
                                        fontSize: '16px',
                                        '::placeholder': {
                                            color: '#aab7c4'
                                        }
                                    },
                                    invalid: {
                                        color: '#fa755a',
                                        iconColor: '#fa755a'
                                    }
                                };
                                // Create an instance of the card Element.
                                var card = elements.create('card', {style: style});
                                // Add an instance of the card Element into the `card-element` <div>.
                                card.mount('#card-element');
                                // Handle real-time validation errors from the card Element.
                                card.on('change', function(event) {
                                    var displayError = document.getElementById('card-errors');
                                    if (event.error) {
                                        displayError.textContent = event.error.message;
                                    } else {
                                        displayError.textContent = '';
                                    }
                                });

                                // Handle form submission.
                                var form = document.getElementById('payment-form');
                                var cardHolderName = document.getElementById('cardholder-name').value;
                                var clientSecret = form.dataset.secret;
                                form.addEventListener('submit', async function(event) {
                                    event.preventDefault();
                                    $('.subscribe-new').attr('disabled','disabled');
                                    // new code
                                    // stripe.createPaymentMethod({
                                    //     type: 'card',
                                    //     card: card
                                    // })

                                    // old code
                                    // const { setupIntent, error } = await stripe.confirmCardSetup(
                                    //     clientSecret, {
                                    //         payment_method: {
                                    //             card,
                                    //             billing_details: { 
                                    //                 name: cardHolderName, 
                                    //                 email: '<?= Auth::user()->email; ?>' 
                                    //             },
                                    //         }
                                    //     });

                                    //new coode
                                    // .then(function(result){
                                    //     // console.log(result);
                                    //     if(result.error){
                                    //         var errorElement = document.getElementById('card-errors');
                                    //         errorElement.textContent = error.message;
                                    //     }else{
                                    //         newFlowCouponFun(result.setupIntent.payment_method)
                                    //     }
                                    // })


                                    // if (error) {
                                    //     // Inform the user if there was an error.
                                    //     var errorElement = document.getElementById('card-errors');
                                    //     errorElement.textContent = error.message;
                                    // } else {
                                    //     var setupIntent1 = setupIntent;
                                    //     newFlowCouponFun('1',setupIntent1);
                                    // }
                                    // stripe.createToken(card).then(function(result) {
                                    //     if (result.error) {
                                    //         var errorElement = document.getElementById('card-errors');
                                    //         errorElement.textContent = result.error.message;
                                    //     } else {
                                    //         newFlowCouponFun(result.token,setupIntent1);
                                    //     }
                                    // });

                                    if($('#coupon').prop('disabled') == true){
                                        couponData = document.getElementById('coupon').value;
                                    }
                                    var cardHolderName = document.getElementById('cardholder-name').value;
                                    fetch('/payment', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            "_token": "{{ csrf_token() }}",
                                            coupon_name: couponData ? couponData : "",
                                            plan_id: plan_id ? plan_id : "",
                                            duration: duration ? duration : "",
                                            cardHolderName: cardHolderName ? cardHolderName : "",
                                        })
                                    })
                                    .then((response) => response.json())
                                    .then((data) => {
                                        console.log(data);
                                        if(data.output.subscriptionId && data.output.clientSecret){
                                            paymentProcess(data.output.subscriptionId, data.output.clientSecret, data.output.customerId);
                                        }
                                    })
                                });

                                function paymentProcess(subscriptionId,clientSecret,customerId){
                                    var cardHolderName = document.getElementById('cardholder-name').value;
                                    const { setupIntent, error } = stripe.confirmCardPayment(
                                        clientSecret, {
                                            payment_method: {
                                                card,
                                                billing_details: { 
                                                    name: cardHolderName, 
                                                    email: '<?= Auth::user()->email; ?>' 
                                                },
                                            }
                                        }
                                    ).then((result) => {
                                        if(result.error){
                                            var errorElement = document.getElementById('card-errors');
                                            errorElement.textContent = result.error.message;
                                        }else{
                                            fetch('/save-payment', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                },
                                                body: JSON.stringify({
                                                    "_token": "{{ csrf_token() }}",
                                                    subscription_id: subscriptionId,
                                                    customer_id: customerId,
                                                    plan_id: plan_id ? plan_id : "",
                                                    payment_intent: result.paymentIntent,
                                                    payment_method: result.paymentIntent.payment_method
                                                })
                                            })
                                            .then((response) => response.json())
                                            .then((data) => {
                                                stripeTokenHandler(data.subData, data.payment_method)
                                            })
                                        }
                                    })
                                }

                                function newFlowCouponFun(paymentMethodId,setupIntent){
                                    if($('#coupon').prop('disabled') == true){
                                        couponData = document.getElementById('coupon').value;
                                    }
                                    var cardHolderName = document.getElementById('cardholder-name').value;
                                    fetch('/payment', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            "_token": "{{ csrf_token() }}",
                                            setupIntent: setupIntent,
                                            payment_method: paymentMethodId,
                                            coupon_name: couponData ? couponData : "",
                                            plan_id: plan_id ? plan_id : "",
                                            cardHolderName: cardHolderName ? cardHolderName : "",
                                        })
                                    })
                                    .then((response) => response.json())
                                    .then((data) => {
                                        if (data.status == 'true') {
                                            // stripeTokenHandler(data.subscription_detail);
                                            if(data.subscription_detail){
                                                
                                            }
                                        }
                                    })
                                }

                                var plan_id = '';
                                var duration = '';
                                function getPlanId(plan,time){
                                    plan_id = plan;
                                    duration = time;
                                }

                                // Submit the form with the token ID.
                                function stripeTokenHandler(setupIntent, payment_method) {
                                    console.log(payment_method);
                                    
                                    // Insert the token ID into the form so it gets submitted to the server
                                    var form = document.getElementById('payment-form');
                                    var hiddenInput = document.createElement('input');
                                    hiddenInput.setAttribute('type', 'hidden');
                                    hiddenInput.setAttribute('name', 'paymentMethod');
                                    hiddenInput.setAttribute('value', payment_method);

                                    var hiddenInput1 = document.createElement('input');
                                    hiddenInput1.setAttribute('type', 'hidden');
                                    hiddenInput1.setAttribute('name', 'stripe_id');
                                    hiddenInput1.setAttribute('value', setupIntent.id);

                                    var hiddenInput2 = document.createElement('input');
                                    hiddenInput2.setAttribute('type', 'hidden');
                                    hiddenInput2.setAttribute('name', 'stripe_price');
                                    hiddenInput2.setAttribute('value', setupIntent.plan.id);

                                    var hiddenInput3 = document.createElement('input');
                                    hiddenInput3.setAttribute('type', 'hidden');
                                    hiddenInput3.setAttribute('name', 'customer_id');
                                    hiddenInput3.setAttribute('value', setupIntent.customer);

                                    var hiddenInput4 = document.createElement('input');
                                    hiddenInput4.setAttribute('type', 'hidden');
                                    hiddenInput4.setAttribute('name', 'payment_status');
                                    hiddenInput4.setAttribute('value', setupIntent.status);

                                    var hiddenInput5 = document.createElement('input');
                                    hiddenInput5.setAttribute('type', 'hidden');
                                    hiddenInput5.setAttribute('name', 'subscription_ends');
                                    hiddenInput5.setAttribute('value', setupIntent.current_period_end);

                                    form.appendChild(hiddenInput);
                                    form.appendChild(hiddenInput1);
                                    form.appendChild(hiddenInput2);
                                    form.appendChild(hiddenInput3);
                                    form.appendChild(hiddenInput4);
                                    form.appendChild(hiddenInput5);
                                    form.submit();
                                }
                            </script>
                    </div>
                @endif
            @endif
        </div>
    </div>

    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('subscriber'))
        <div class="grid grid-cols-2 gap-x-5 mt-10">
            <div class="col-span-2 lg:col-span-1 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Danger zone') }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ __('The subscription terminates when the duration of your subscription has expired.') }}</p>
                    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('subscriber') && $user->autosubsc == '')
                        <div class="d-flex" style="display: flex; justify-content: flex-end; margin-top: 20px;">
                            {!! Form::model($user,['route' =>['home.users.cancelsub',$user], 'method' => 'post']) !!}
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="confirm('{{ __('Do you want to cancel auto subscription?') }}');">{{ __('Cancel Subscription') }}</button>
                            {!! Form::close() !!}
                        </div>
                    @else
                        <div class="mt-5">
                            {{ __('Your subscription will expire') }}: <b>{{ \Carbon\Carbon::parse(Auth::user()->manual_expire) }}</b>
                        </div>    
                    @endif
                </div>
            </div>

            <div class="col-span-2 lg:col-span-1 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Automatic renewal') }}</h3>
                    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('subscriber') && $price != 1 && $price != 2)
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ __('You have an account with manual payment. Insert a payment card above or contact an administrator at info@emiweb.se to extend your subscription.') }}</p>
                    @else
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ __('By activating automatic renewal, you do not risk your account being deactivated when the subscription period expires.') }}</p>
                    @endif


                    <div class="d-flex" style="margin-top: 5px; display: flex; align-items: center;">
                        @if(\Illuminate\Support\Facades\Auth::user()->hasRole('subscriber') && $price != 1 && $price != 2)
                            <div class="on-off-toggle disabled">
                                <input class="on-off-toggle__input" type="checkbox" id="bopis" onclick="updateAutoStatus(this)" {{ isset(Auth::user()->is_auto_sub) && Auth::user()->is_auto_sub == 1 ? "checked" : ''}} disabled/>
                                <label for="bopis" class="on-off-toggle__slider disabled"></label>
                            </div> 
                            <div class="switch-status disabled">
                                <b>
                                    {{ __('Not active') }}
                                </b>
                            </div>  
                        @else
                            <div class="on-off-toggle">
                                <input class="on-off-toggle__input" type="checkbox" id="bopis" onclick="updateAutoStatus(this)" {{ isset(Auth::user()->is_auto_sub) && Auth::user()->is_auto_sub == 1 ? "checked" : ''}}/>
                                <label for="bopis" class="on-off-toggle__slider"></label>
                            </div>  
                            <div class="switch-status">
                                <b>
                                    @if(isset(Auth::user()->is_auto_sub) && Auth::user()->is_auto_sub == 1)
                                        {{ __('Active') }}
                                    @else
                                        {{ __('Not active') }}
                                    @endif
                                </b>
                            </div>  
                        @endif
                    </div>
                    <div class="expire-line">
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            @if(isset(Auth::user()->is_auto_sub) && Auth::user()->is_auto_sub == 1)
                                <span>{{ __('Your subscription is automatically renewed') }}</span>
                            @else
                                <span>{{ __('Your subscription expires') }}</span>
                            @endif
                            @if($price == 1)
                                {{ \Carbon\Carbon::parse(Auth::user()->subscription('Regular Subscription')->created_at)->addMonths(12)->format('Y-m-d') }}
                            @elseif($price == 2)
                                {{ \Carbon\Carbon::parse(Auth::user()->subscription('3 Months')->created_at)->addMonths(3)->format('Y-m-d') }}
                            @elseif(\Illuminate\Support\Facades\Auth::user()->hasRole('subscriber'))
                                {{ \Carbon\Carbon::parse(Auth::user()->manual_expire)->format('Y-m-d') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function updateAutoStatus(e){
                if(e.checked == true){
                    fetch('/auto-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            "_token": "{{ csrf_token() }}",
                            "is_auto_sub": 1
                        })
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        document.querySelector('.switch-status').innerHTML = "{{ __('Active') }}";
                        document.querySelector('.expire-line span').innerHTML = "{{ __('Your subscription is automatically renewed') }}";
                    })
                }else{
                    fetch('/auto-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            "_token": "{{ csrf_token() }}",
                            "is_auto_sub": 0
                        })
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        document.querySelector('.switch-status').innerHTML = "{{ __('Not active') }}";
                        document.querySelector('.expire-line span').innerHTML = "{{ __('Your subscription expires') }}";
                    })
                }
            }
        </script>

    @endif


</x-app-layout>
