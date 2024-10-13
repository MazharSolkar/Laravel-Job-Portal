<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function index() {
        $applications = JobApplication::latest()
                        ->with('job', 'user', 'employer')
                        ->paginate(10);
        return view('admin.job-applications.list', compact('applications'));
    }
}
