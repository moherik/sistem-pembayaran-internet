<x-guest-layout>
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('img/logo.png') }}" width="300"/>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <x-jet-input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <x-jet-input id="password" class="form-control" type="password" name="password" placeholder="Kata Sandi" required autocomplete="current-password" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <x-jet-checkbox id="remember_me" name="remember" />
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <x-jet-button class="btn btn-primary btn-block">
                                {{ __('Log in') }}
                            </x-jet-button>
                        </div>
                    </div>

                    <!-- <div class="mt-4">
                        @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                        @endif
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
