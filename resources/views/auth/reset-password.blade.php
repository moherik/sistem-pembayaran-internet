<x-guest-layout>
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('img/logo.png') }}" width="300" />
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Reset Kata Sandi</p>

                <x-jet-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="block">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-jet-button class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </x-jet-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-guest-layout>
