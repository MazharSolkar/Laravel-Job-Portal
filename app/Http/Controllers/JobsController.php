<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\JobType;
use App\Models\JobApplication;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    public function index(Request $request) {
        $categories = Category::where('status',1)->get();
        $jobTypes = JobType::where('status',1)->get();

        $jobs = JOB::where('status',1);

        // Search using keyword
        if(!empty($request->keywords)) {
            $jobs = $jobs->where(function($query) use($request) {
                $query->orWhere('title', 'like', '%'.$request->keywords.'%');
                $query->orWhere('keywords', 'like', '%'.$request->keywords.'%');
            });
        }

        // Search using location
        if(!empty($request->job_location)) {
            $jobs = $jobs->where('job_location', $request->job_location);
        }

        // Search using category
        if(!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        // Search using Job Type
        $jobTypeArray = [];
        if(!empty($request->job_type)) {
            // 1, 2, 3
            $jobTypeArray = $request->job_type;
            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        // Search using experience
        if(!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }

        // Sorting
        $sort = $request->get('sort', 1); //if sort parameter is not there then set value or $sort as 1.

        if($sort == 0) {
            $jobs = $jobs->oldest();
        } else {
            $jobs = $jobs->latest();
        }

        $jobs = $jobs->with(['jobType', 'category'])->paginate(9);

        return view('jobs', compact('categories', 'jobTypes', 'jobs', 'jobTypeArray'));
    }

    // This method will show job details page
    public function detail($id) {

        $job = Job::where('id',$id)
                    ->with(['jobType', 'category'])
                    ->first();
        // dd($job);

        if($job == null) {
            abort(404);
        }

        return view('job.jobDetail', compact('job'));
    }

    public function applyJob(Request $request) {

        // dd($request->id);

        $job = Job::where('id', $request->id)->first();

        // If job not found in db
        if($job == null) {
            $message = 'Job does not exist';
            return redirect()->back()->with('error', $message);
        }

        // You can not apply on the job you posted
        $employer_id = $job->user_id;

        if($employer_id == Auth::user()->id) {
            $message = 'You can not apply on the job you posted';
            return redirect()->back()->with('error', $message);
        }

        // You can not apply on a job twice
        $hasApplied = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $request->id
        ])->exists();

        if($hasApplied) {
            $message = 'Already applied';
            return redirect()->back()->with('error', $message);
        }

        // apply
        JobApplication::create([
            'job_id' => $request->id,
            'user_id' => Auth::id(),
            'employer_id' => $job->user_id,
            'applied_date' => now(),
        ]);

        return redirect()->back()->with('success','You have successfully applied');
    }
}
