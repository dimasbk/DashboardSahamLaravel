@extends('layouts.app')

@section('content')



<section class="signup">
    <div class="container">
        <div class="signup-content">
            <div class="signup-form">
                <h2 class="form-title">Sign up</h2>
                <form method="POST" action="{{ route('register') }}" class="register-form" id="register-form">
                    @csrf
                    <div class="form-group">
                        <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="name" id="name" placeholder="Your Name" />
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <input type="email" name="email" id="email" placeholder="Your Email" required
                            autocomplete="email" />
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="password" id="password" placeholder="Password" required
                            autocomplete="new-password" />
                    </div>
                    <div class="form-group">
                        <label for="password-confirm"><i class="zmdi zmdi-lock-outline"></i></label>
                        <input id="password-confirm" type="password" name="password_confirmation"
                            placeholder="Repeat your password" required autocomplete="new-password">
                    </div>
                    <div class="form-group form-button">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="signup-image">
                <figure><img src="{{asset('template')}}/colorlib-regform-7/images/signup-image.jpg" alt="sing up image">
                </figure>
                <a href="/login" class="signup-image-link">I am already member</a>
            </div>
        </div>
    </div>
</section>



<!-- JS -->
<script src="{{asset('template')}}/colorlib-regform-7/vendor/jquery/jquery.min.js"></script>
<script src="{{asset('template')}}/colorlib-regform-7/js/main.js"></script>
@endsection