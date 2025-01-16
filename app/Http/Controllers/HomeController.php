<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsfeed; // Assuming you have a Newsfeed model
use App\Models\Slideshow; // Import the Slideshow model

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $data_announce = Newsfeed::where('status', true)
            ->where('categories', 'ข่าว')  // Filter by category 'ข่าว'
            ->orderBy('id', 'desc')
            ->paginate(5); // Use paginate to manage pagination

        $data_document = Newsfeed::where('status', true)
            ->where('categories', 'เอกสาร')  // Filter by category 'ข่าว'
            ->orderBy('id', 'desc')
            ->paginate(5); // Use paginate to manage pagination

        $data_form = Newsfeed::where('status', true)
            ->where('categories', 'แบบฟอร์ม')  // Filter by category 'ข่าว'
            ->orderBy('id', 'desc')
            ->paginate(5); // Use paginate to manage pagination



        $banners = Slideshow::orderBy('slideshow_id', 'asc')->get();


        return view('home', compact('data_announce', 'banners', 'data_document', 'data_form'));
    }

    

}
