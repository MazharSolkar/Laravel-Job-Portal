<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;

class JobsController extends Controller
{
    public function index() {
        $categories = Category::where('status',1)->get();
        $jobTypes = JobType::where('status',1)->get();

        $jobs = Job::where('status', 1)
                    ->with('jobType')
                    ->latest()
                    ->paginate(9);

        return view('jobs', compact('categories', 'jobTypes', 'jobs'));
    }
}
