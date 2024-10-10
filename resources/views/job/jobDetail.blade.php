@extends('app')

@section('main')
<section class="section-4 bg-2">    
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{route('jobs')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            @include('message')
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{$job->title}}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i>&nbsp;{{$job->job_location}}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i>&nbsp;{{$job->jobType->name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <form action="{{route('saveJob')}}" method="POST">
                                    @CSRF
                                    <input type="hidden" name="id" value="{{ $job->id }}">
                                    <button class="apply_now" style="border:none; background-color:white;">
                                        <a id="save-job-btn" class="heart_mark" style="{{$jobExists? 'background-color: #00D363; color: #fff' : ''}}"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            @if (!empty($job->description))
                                <h4>Job description</h4>
                                {!! $job->description !!}
                            @endif
                        </div>
                        <div class="single_wrap">
                            @if (!empty($job->responsibility))
                                <h4>Responsibility</h4>
                                {!! $job->responsibility !!}
                            @endif
                        </div>
                        <div class="single_wrap">
                            @if (!empty($job->description))
                                <h4>Qualifications</h4>
                                {!! $job->description !!}
                            @endif
                        </div>
                        <div class="single_wrap">
                            @if (!empty($job->benefits))
                                <h4>Benefits</h4>
                                {!! $job->benefits !!}
                            @endif
                        </div>
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end d-flex justify-content-end">
                            <form action="{{ route('applyJob', $job->id) }}" method="POST" style="margin-right: 10px;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $job->id }}">
                                @if (Auth::check())
                                    <button type="submit" class="btn btn-primary">Apply</button>
                                @else
                                    <a href="#" class="btn btn-primary disabled">Login to Apply</a>
                                @endif
                            </form>

                            <form action="{{ route('saveJob', $job->id) }}" method="POST" style="margin-right: 10px;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $job->id }}">
                                @if (Auth::check())
                                    <button type="submit" class="btn btn-secondary">Save</button>
                                @else
                                    <a href="#" class="btn btn-secondary disabled">Login to Save</a>
                                @endif
                            </form>
                        </div>                        
                    </div>
                </div>

                {{-- Only show applicants to the user who created job (i.e. employer) --}}
                @if(Auth::user() && Auth::user()->id == $job->user_id)
                <div class="card shadow border-0 mt-4">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>Applicants</h4>
                                    </a>

                                </div>
                            </div>
                            <div class="jobs_right"></div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Applied Data</th>
                            </tr>
                            @forelse ($applications as $application)
                                <tr>
                                    <td>{{$application->user->name}}</td>
                                    <td>{{$application->user->email}}</td>
                                    <td>{{$application->user->mobile}}</td>
                                    <td>{{$application->applied_date->format('F j, Y')}}</td>
                                </tr>  
                            @empty
                                <tr>
                                    <td colspan="4">No Applicants yet</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
                @endif

            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Job Summery</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span>{{$job->created_at->format('F j, Y')}}</span></li>
                                <li>Vacancy: <span>{{$job->vacancy}}</span></li>
                                @if (!empty($job->salary))
                                    <li>Salary: <span>{{$job->salary}}</span></li>
                                @endif
                                <li>Location: <span>{{$job->job_location}}</span></li>
                                <li>Job Nature: <span>{{$job->jobType->name}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Company Details</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Name: <span>{{$job->company_name}}</span></li>

                                @if (!empty($job->company_location))
                                    <li>Locaion: <span>{{$job->company_location}}</span></li>
                                @endif

                                @if (!empty($job->company_website))
                                    <li>Webite: <span><a href="{{$job->company_website}}" target="blank">{{$job->company_website}}</a></span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection