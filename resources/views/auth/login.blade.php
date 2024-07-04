@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-8">
                <div class="card" id="login">
                    <div class="card-header fw-bold display-6">Accedi</div>

                    <div class="card-body" style="">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4 row" style="">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Indirizzo E-Mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            Ricordami
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="mine-custom-btn mb-3">
                                        Accedi
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Password Dimenticatia?
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
