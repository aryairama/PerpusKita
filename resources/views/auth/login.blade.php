<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PerpusKita</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
</head>

<body>
    <div id="app">
        <main class="py-4 mt-5">
            <div class="container">
                <div class="row justify-content-center mt-5 mr-lg-n5 mr-md-n5">
                    <div class="col-md-7 d-none d-md-block d-lg-block align-self-center text-center">
                        <div class=" rounded">
                            <div class="text h1 text-white">
                                welcome to PerpusKita website
                            </div>
                            <div class="text h5 text-white">
                                Books are a window to the world, keep reading.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card shadow bg-light shadow-lg">
                            <div class="card-header border-0 bg-light text-center text-success h1 p-3">
                                {{ __('PerpusKita') }}</div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-10">
                                            <input id="email" type="email"
                                                class="form-control form-control-lg font-weight-bolder @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                                autofocus placeholder="email@mail.com">
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
                                                name="password" required autocomplete="current-password"
                                                placeholder="password">
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include('loader.loader')
    <script src="{{ asset('/js/login.js') }}"></script>
    <script src="{{ asset('/assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('/js/loader.js') }}"></script>
</body>
</html>
