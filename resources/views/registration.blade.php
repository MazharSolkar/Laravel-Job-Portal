@extends('app')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Register</h1>
                        <form action="{{route('account.processRegistration')}}" method="POST">
                            @CSRF
                            @method('POST')
                            <div class="mb-3">
                                <label for="name" class="mb-2">Name*</label>
                                <input value="{{old('name')}}" type="text" name="name" id="name" class="form-control @error('name') border-danger @enderror" placeholder="Enter Name">
                                @error('name')<p class="text-danger">{{ $message }}</p>@enderror
                            </div> 
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input value="{{old('email')}}" type="text" name="email" id="email" class="form-control @error('name') border-danger @enderror" placeholder="Enter Email">
                                @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                            </div> 
                            <div class="mb-3">
                                <label for="password" class="mb-2">Password*</label>
                                <input value="{{old('password')}}" type="password" name="password" id="password" class="form-control @error('name') border-danger @enderror" placeholder="Enter Password">
                                @error('password')<p class="text-danger">{{ $message }}</p>@enderror
                            </div> 
                            <div class="mb-3">
                                <label for="password_confirmation" class="mb-2">Confirm Password*</label>
                                <input value="{{old('password_confirmation')}}" type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('name') border-danger @enderror" placeholder="Confirm Password">
                                @error('password_confirmation')<p class="text-danger">{{ $message }}</p>@enderror
                            </div> 
                            <button class="btn btn-primary mt-2">Register</button>
                        </form>                    
                    </div>
                    <div class="mt-4 text-center">
                        <p>Have an account? <a  href="{{route('account.login')}}"">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection