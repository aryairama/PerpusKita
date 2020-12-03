@extends('layouts.app')
@section('js')
<script>
    togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
</script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow bg-light shadow-lg">
                <div class="card-header text-center h1 bg-success p-5 text-white mb-3">{{ __('PerpusKita') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row justify-content-center">
                            <div class="col-md-10">
                                <input id="email" type="email"
                                    class="form-control form-control-lg font-weight-bolder @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="email@mail.com">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-10 pass">
                                <input id="password" type="password"
                                    class="form-control form-control-lg font-weight-bolder @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password" placeholder="password">
                                    <i class="fas fa-eye" id="togglePassword"></i>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if (Route::has('password.request'))
                                        <a class="btn btn-link text-success" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-5 justify-content-center">
                            <div class="col-md-10">
                                <button type="submit" class="btn bg-success text-white btn-block btn-lg">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5 text-center">
                            <p class="text-center p-0 m-0">Don’t have an account?</p>
                            <a href="{{ route('register') }}" class="text-success h4">REGISTER NOW</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
