@extends('app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            @include('message')
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Jobs</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">Job Applications</h3>
                                </div>
                                
                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Job Title</th>
                                            <th scope="col">Applicant</th>
                                            <th scope="col">Employer</th>
                                            <th scope="col">Applied Date </th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if (!empty($applications))
                                            @foreach ($applications as $application)
                                            <tr class="active">
                                                <td>
                                                    <p>{{$application->job->title}}</p>
                                                </td>
                                                <td>{{$application->user->name}}</td>
                                                <td>{{$application->employer->name}}</td>
                                                <td>{{$application->applied_date->format('d/m/y')}}</td>

                                                <td>
                                                    <div class="action-dots">
                                                        <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <form action="{{route('admin.jobApplications.destroy', $application->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
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
                        {{$applications->links()}}
                    </div> 
                </div>
            </div>
        </div>
    </section>
@endsection