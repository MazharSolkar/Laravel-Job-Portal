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
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">Saved Jobs</h3>
                                </div>
                                
                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Applicants</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if (!empty($savedJobs))
                                            @foreach ($savedJobs as $savedJob)
                                            <tr class="active">
                                                <td>
                                                    <div class="job-name fw-500">{{$savedJob->job->title}}</div>
                                                    <div class="info1">{{$savedJob->job->jobType->name}} . {{$savedJob->job->job_location}}</div>
                                                </td>
                                                <td>{{$savedJob->job->jobApplications->count()}} Applications</td>
                                                <td>
                                                    @if ($savedJob->job->status == 1)
                                                        <div class="job-status text-capitalize">Active</div>  
                                                    @else
                                                        <div class="job-status text-capitalize">Block</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-dots">
                                                        <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item" href="{{ route('jobDetail', $savedJob->job_id) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                            <li>
                                                                <form action="{{ route('account.deleteSavedJob', $savedJob->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Job Application?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i> Remove
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{$savedJobs->links()}}
                    </div> 
                </div>
            </div>
        </div>
    </section>
@endsection