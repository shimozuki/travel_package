<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\TravelPackage;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $travel_packages = TravelPackage::with('galleries')->where('type', 'Daily Tour')->get();
        $rinjani = TravelPackage::with('galleries')->where('type', 'Trip To Rinjani')->get();
        $blogs = Blog::get()->take(3);

        return view('homepage', compact('travel_packages','blogs','rinjani'));
    }
}
