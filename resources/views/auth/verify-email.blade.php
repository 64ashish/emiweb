<x-app-layout>
    <div class="bg-light p-5 rounded">


        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                A fresh verification link has been sent to your email address.
            </div>
        @endif
        {{ __('Before proceeding, please check your email for a verification link. ') }}
        {{ __('If you did not receive the email, ') }}
        <form action="{{ route('verification.send') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="d-inline btn btn-link p-0 underline cursor-pointer">
                {{ __('click here to request another') }}
            </button>.
        </form>
    </div>

</x-app-layout>
