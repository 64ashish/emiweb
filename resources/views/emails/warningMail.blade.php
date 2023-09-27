<!DOCTYPE html>
<html>
<head>
    <title>emiweb</title>
</head>
<body>
    <h3>{{ __('Hi') }} {{ $user->name }},</h3>

    <h4>{{ __('Your membership at emiweb is about to expire on') }} {{ $user->manual_expire }}. {{ __("We hope you've enjoyed") }}.</h4>

    <h3>{{ __('RENEW NOW') }}</h3>

    <h4>{{ __("Good news! There's still time to renew, and it's as easy as ever pick the subscription that suits your needs and follow the prompts") }}.</h4>

    <h3>{{ __('Thanks') }},<b>EMIWEB</b>
    </h3>
</body>
</html>




