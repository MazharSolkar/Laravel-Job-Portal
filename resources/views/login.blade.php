@extends('app')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            @include('message')
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Login</h1>
                        <form action="{{route('account.processLogin')}}" method="POST">
                            @CSRF
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input value="{{old('email')}}" type="text" name="email" id="email" class="form-control @error('email') border-danger @enderror" placeholder="example@example.com">
                                @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                            </div> 
                            <div class="mb-3">
                                <label for="password" class="mb-2">Password*</label>
                                <input value="{{old('password')}}" type="password" name="password" id="name" class="form-control @error('password') border-danger @enderror" placeholder="Enter Password">
                                @error('password')<p class="text-danger">{{ $message }}</p>@enderror
                            </div> 
                            <div class="justify-content-between d-flex">
                            <button class="btn btn-primary mt-2">Login</button>
                                <a href="{{route('account.forgotPassword')}}" class="mt-3">Forgot Password?</a>
                            </div>
                        </form>                    
                    </div>
                    <div class="mt-4 text-center">
                        <p>Do not have an account? <a  href="{{route('account.register')}}">Register</a></p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>
@endsection