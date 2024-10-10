@extends('app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        @include('message')
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Post a Job</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('sidebar')
            </div>

            <div class="col-lg-9">
            <form action="{{route('account.postJob')}}" method="POST">
                @CSRF
                    <div class="card border-0 shadow mb-4 ">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Job Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="title" class="mb-2">Title<span class="req">*</span></label>
                                    <input value="{{old('title')}}" type="text" name="title" id="title" placeholder="Job Title" id="title" name="title" class="form-control">
                                    @error('title')<p class="text-danger">{{ $message }}</p>@enderror
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="category_id" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if(!empty($categories))
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="">No categories available</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="job_type_id" class="mb-2">Job Nature<span class="req">*</span></label>
                                    <select name="job_type_id" id="job_type_id" class="form-select">
                                        <option value="">Select Job Nature</option>
                                        @forelse($jobTypes as $jobType)
                                            <option value="{{$jobType->id}}" value="{{ $category->id }}" {{ old('job_type_id') == $jobType->id ? 'selected' : '' }}>{{$jobType->name}}</option>
                                        @empty
                                            <option value="">No options available</option>
                                        @endforelse
                                        <option>Remote</option>
                                        <option>Freelance</option>
                                    </select>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="vacancy" class="mb-2">Vacancy<span class="req">*</span></label>
                                    <input value="{{old('vacancy')}}" type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                    @error('vacancy')<p class="text-danger">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="salary" class="mb-2">Salary</label>
                                    <input value="{{old('salary')}}" type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                                    @error('salary')<p class="text-danger">{{ $message }}</p>@enderror
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="job_location" class="mb-2">Location<span class="req">*</span></label>
                                    <input value="{{old('job_location')}}" type="text" placeholder="job location" id="job_location" name="job_location" class="form-control">
                                    @error('job_location')<p class="text-danger">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="form-control textarea" name="description" id="description" cols="5" rows="5" placeholder="Description">{{old('description')}}</textarea>
                                @error('description')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="benefits" class="mb-2">Benefits</label>
                                <textarea class="form-control textarea" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{old('benefits')}}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="responsibility" class="mb-2">Responsibility</label>
                                <textarea class=" form-control textarea" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{old('responsibility')}}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="qualification" class="mb-2">Qualifications</label>
                                <textarea class="form-control textarea" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{old('qualications')}}</textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label for="experience" class="mb-2">Experience<span class="req">*</span></label>
                                <select name="experience" id="experience" class="form-select">
                                    <option value="">Select Experience</option>
                                    <option value="0" {{ old('experience') == '0' ? 'selected' : '' }}>Fresher</option>
                                    <option value="1" {{ old('experience') == '1' ? 'selected' : '' }}>1 Year</option>
                                    <option value="2" {{ old('experience') == '2' ? 'selected' : '' }}>2 Year</option>
                                    <option value="3" {{ old('experience') == '3' ? 'selected' : '' }}>3 Year</option>
                                    <option value="4_plus" {{ old('experience') >= '4' ? 'selected' : '' }}>4+ Years</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="keywords" class="mb-2">Keywords</label>
                                <input value="{{old('keywords')}}" type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                            </div>

                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="company_name" class="mb-2">Company Name<span class="req">*</span></label>
                                    <input value="{{old('company_name')}}" type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                    @error('company_name')<p class="text-danger">{{ $message }}</p>@enderror
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="company_location" class="mb-2">Location</label>
                                    <input value="{{old('company_location')}}" type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="company_website" class="mb-2">Website</label>
                                <input value="{{old('company_website')}}" type="text" placeholder="Website" id="company_website" name="company_website" class="form-control">
                            </div>
                        </div> 
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Post Job</button>
                        </div>               
                    </div>
                    
                </div>
            </form>
    </div>
</section>
@endsection