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

    public function destroy($id) {

        $JobApplication = JobApplication::find($id);

        if($JobApplication == null) {
            return redirect()->back()->with('error', 'Job Application not Found');
        }

        $JobApplication->delete();
        return redirect()->back()->with('success', 'Job Application deleted Successfully.');
    }
}
