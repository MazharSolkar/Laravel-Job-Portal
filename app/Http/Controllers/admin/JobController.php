<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Category;

class JobController extends Controller
{
    public function index() {
        $jobs = Job::latest()->with('user', 'jobApplications')->paginate(10);

        return view('admin.jobs.list', compact('jobs'));
    }

    public function edit($id) {
        // $job = Job::find($id);
        // if($job == null) {
        //     abort(404);
        // }
        //* shorthand for above code
        $job = Job::findOrFail($id);

        $categories = Category::orderBy('name', 'ASC')->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->get();

        return view('admin.jobs.edit', compact('job', 'categories', 'jobTypes'));
    }

    public function update(Request $request, $id) {
    
        $validateData = $request->validate([
            'title' => 'required|min:5|max:200',
            'category_id' => 'required',
            'job_type_id' => 'required',
            'vacancy' => 'required|integer',
            'job_location' => 'required|max:50',
            'description' => 'required|max:250',
            'company_name' => 'required|min:3|max:50',
            'experience' => 'required'
        ]);
    
        // Add additional fields
        $validateData['salary'] = $request->salary;
        $validateData['company_location'] = $request->company_location;
        $validateData['company_website'] = $request->company_website;
        $validateData['benefits'] = $request->benefits;
        $validateData['responsibility'] = $request->responsibility;
        $validateData['qualifications'] = $request->qualifications;
        $validateData['keywords'] = $request->keywords;
        $validateData['status'] = $request->status;
        //? empty() -> returns true if the isFeatured field missing or don't contain value.
        
        // Update the job record in the database
        $job = Job::find($id);
        $job->isFeatured = (!empty($request->isFeatured)) ? $request->isFeatured : 0;
        //? $job->update() -> method updates the model with provided data plus automatically triggers the saving process therefore there is no need of calling $job->save() as we are using $job->update().
        $job->update($validateData);
    
        return redirect()->route('admin.jobs')
                         ->with('success', 'Job Updated Successfully.');
    }
}
