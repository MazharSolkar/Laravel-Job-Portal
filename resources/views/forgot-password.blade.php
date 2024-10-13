@extends('app')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            @include('message')
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Forgot Password</h1>
                        <form action="{{route('account.processForgotPassword')}}" method="POST">
                            @CSRF
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input value="{{old('email')}}" type="text" name="email" id="email" class="form-control @error('email') border-danger @enderror" placeholder="example@example.com">
                                @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                            </div> 
 
                            <div class="justify-content-between d-flex">
                                <button class="btn btn-primary mt-2">Submit</button>
                            </div>
                        </form>                    
                    </div>
                    <div class="mt-4 text-center">
                        <p>Already have an account? <a  href="{{route('account.login')}}">Back to Login</a></p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>
@endsection