<x-guest-layout>
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('img/logo.png') }}" width="300" />
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Lupa Kata Sandi</p>

                <x-jet-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="block">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-jet-button class="btn btn-primary">
                            {{ __('Email Password Reset Link') }}
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
