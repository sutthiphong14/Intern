<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsfeed; // Assuming you have a Newsfeed model

use App\Models\Slideshow; // Import the Slideshow model

class HomeController extends Controller
{
    
    public function index()
{
    // ดึงข้อมูลข่าวสาร
    $data = Newsfeed::where('status', true)
        ->orderBy('id', 'desc')
        ->take(10)
        ->get();

    // ดึงข้อมูลแบนเนอร์
    $banners = Slideshow::orderBy('slideshow_id', 'asc')->get();

    // ส่งข้อมูลทั้งสองไปยัง View
    return view('home', compact('data', 'banners'));
}




}