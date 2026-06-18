@extends('layouts.app')
@section('content')
<div class="login-wrapper">
    <div class="login-box">
        <div class="row g-0">
            <!-- Left Side -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="login-form">
                    <h1>Welcome Back!</h1>
                    <p>
                        Sign in with your Email and Password.
                    </p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-4">
                            <input id="email"
                                   type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="Email Address"
                                   required
                                   autofocus>                                  
                            @error('email')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <input id="password"
                                   type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   placeholder="Password"
                                   required>
                            @error('password')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div><br><br>
                        <button type="submit" class="login-btn">
                            Login
                        </button>
                    </form>
                    @if (Route::has('register'))
                    <div class="register-link">
                        Don't have an account?
                        <a href="{{ route('register') }}">
                            Register Now
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            <!-- Right Side -->
            <div class="col-md-6">
                <div class="food-image"></div>
            </div>
        </div>
    </div>
</div>
@endsection