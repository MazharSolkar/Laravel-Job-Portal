<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    public function index() {
        $jobs = Job::latest()->with('user', 'jobApplications')->paginate(10);

        return view('admin.jobs.list', compact('jobs'));
    }
}
