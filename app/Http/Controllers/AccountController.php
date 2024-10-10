<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\SavedJob;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    // This method will show user registration page
    public function registration() {
        return view('registration');
    }

    // This method will save a user
    public function processRegistration(Request $request) {
        $validateData = $request->validate([
            'name' => 'required:min:5|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:password_confirmation',
            'password_confirmation' => 'required'
        ]);

        // Hashing the password before storing in db
        $validateData['password'] = bcrypt($request->password);

        // Remove password_confirmation from the data array since we don't need to store it
        unset($validateData['password_confirmation']);

        // Create the user
        $user = User::create($validateData);

        return redirect()->route('account.login')
                         ->with('success', 'Registrated Successfully.');
    }
    // This method will show user login page
    public function login() {
        return view('login');
    }

    public function processLogin(Request $request) {
        $validateData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($validateData)) {
            return redirect()->route('account.profile');
        } else {
            return redirect()->route('account.login')->with('error', 'Invalid Credentials.');
        }
    }

    public function profile() {

        // getting the logged-in user.
        $user = Auth::user();

        return view("profile", ['user'=> $user]);
    }

    public function updateProfile(Request $request) {

        // Getting the logged-in user.
        $user = Auth::user();

        $validateData = $request->validate([
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$user->id.'id',
            'mobile' => 'nullable|numeric',
            'designation' => 'nullable|string|max:50'
        ]);

        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->mobile = $request->mobile;
        // $user->designation = $request->designation;
        // $user->save();

        $user->update($validateData);

        return redirect()->route('account.profile')->with('success', 'Profile updated successfully.');
    }

    public function updateProfilePic(Request $request) {
        // return dd($request);
        $user = Auth::user();

        $validatedData = $request->validate([
            'image' => 'required|image',
        ]);

        $image = $request->image;

        $extension = $image->getClientOriginalExtension();
        $imgName = $user->id.'-'.time().'.'.$extension;

        $image->move(public_path('/profile_pic'), $imgName);

        // create a small thumbnail
        $sourcePath = public_path('/profile_pic/'.$imgName);
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($sourcePath);

        // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
        $image->cover(150, 150);
        $image->toPng()->save(public_path('/profile_pic/thumb/'.$imgName));

        // Delete old profile pic
        File::delete(public_path('/profile_pic/thumb/'.$user->image));
        File::delete(public_path('/profile_pic/'.$user->image));

        $user->update(['image'=> $imgName]);

        return redirect()->back()->with('success', 'Profile picture updated successfully.');

    }

    public function updatePassword(Request $request) {
        
        $validatedData = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);
        
        $user = Auth::user();

        if(Hash::check($request->old_password, $user->password) == false) {
            return redirect()->back()->with('error', 'Your old password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function createJob(Request $request) {
        $user = Auth::user();
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        return view('job.create',compact('user','categories','jobTypes'));
    }

    public function postJob(Request $request) {
        
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
        
        // $validateData['salary'] = $request->input('salary');
        $validateData['user_id'] = Auth::user()->id;
        $validateData['salary'] = $request->salary;
        $validateData['company_location'] = $request->company_location;
        $validateData['company_website'] = $request->company_website;
        $validateData['benefits'] = $request->benefits;
        $validateData['responsibility'] = $request->responsibility;
        $validateData['qualifications'] = $request->qualifications;
        $validateData['keywords'] = $request->keywords;

        // dd($validateData);
        $job = Job::create($validateData);

        return redirect()->route('account.myJobs')
                        ->with('success', 'New Job Posted Successfully.');
    }

    public function myJobs() {
        $user = Auth::user();
        $jobs = Job::where('user_id',$user->id)
                    ->with('jobType')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);

        // dd($jobs);
        return view('job.my-jobs', compact('user', 'jobs'));
    }

    public function editJob(Job $job) {
        // Ensure that the authenticated user owns the job
        if ($job->user_id !== Auth::user()->id) {
            abort(403); // 403 Forbidden if user doesn't own the job
        }
        
        $user = Auth::user();
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        return view('job.edit', compact('user', 'categories', 'jobTypes', 'job'));
    }

    public function updateJob(Request $request, Job $job) {
        // Ensure that the authenticated user owns the job
        if (Auth::user()->id !== $job->user_id) {
            abort(403); // 403 Forbidden if user doesn't own the job
        }
    
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
    
        // Update the job record in the database
        $job->update($validateData);
    
        return redirect()->route('account.myJobs')
                         ->with('success', 'Job Updated Successfully.');
    }

    public function deleteJob(Job $job)
    {
        // Ensure the user owns the job
        if (Auth::user()->id !== $job->user_id) {
            abort(403); // 403 Forbidden if the user doesn't own the job
        }
    
        $job->delete();
    
        return redirect()->route('account.myJobs')
                         ->with('success', 'Job deleted successfully.');
    }
    
    public function myJobApplications() {
        //* Eloquet ORM way Get job applications for the authenticated user using Eloquent relationship
        // $jobApplications = Auth::user()->jobApplications;

        $jobApplications = JobApplication::where('user_id', Auth::user()->id)
                                        ->with(['job', 'job.jobType', 'job.jobApplications'])
                                        ->latest()
                                        ->paginate(10);
        // dd($jobApplications);

        return view('job.my-job-applications', compact('jobApplications'));
    }

    public function deleteJobApplication(JobApplication $application) {
         // Check if the authenticated user is the owner of the job application
        if ($application->user_id !== Auth::user()->id) {
            return redirect()->back()->with('error', 'Job application not found');
        }

        // Delete the job application
        $application->delete();

        return redirect()->back()->with('success', 'Job application deleted successfully.');
    }

    public function savedJobs() {
        $savedJobs = SavedJob::where(['user_id' => Auth::user()->id])
                                ->with('job','job.jobType', 'job.jobApplications')
                                ->latest()
                                ->paginate(10);
        

        return view('job.saved-Jobs', compact('savedJobs'));
    }

    public function deleteSavedJob(SavedJob $job) {
        // Check if the authenticated user is the owner of the job application
       if ($job->user_id !== Auth::user()->id) {
           return redirect()->back()->with('error', 'Job not found');
       }

       // Delete the saved job
       $job->delete();

       return redirect()->back()->with('success', 'Saved Job deleted successfully.');
   }
}
