<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Job;

class HomeController extends Controller
{
    // This method will show our home page
    public function index() {

        $categories = Category::where('status',1)->orderBy('name', 'ASC')->take(8)->get();

        $newCategories = Category::where('status',1)->orderBy('name', 'ASC')->take(8)->get();

        $featuredJobs = Job::where('status',1)
                                    ->latest()
                                    ->with('jobType')
                                    ->where('isFeatured',1)->take(6)->get();

        $latestJobs = Job::where('status',1)
                                    ->latest()
                                    ->with('jobType')
                                    ->take(6)->get();
        return view(
            'home', 
            compact('categories', 'newCategories', 'featuredJobs', 'latestJobs')
    );
    }
}
