<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsfeed; // Assuming you have a Newsfeed model

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Fetch the latest 10 news items
        $data = Newsfeed::orderBy('created_at', 'desc')->take(10)->get();

        return view('home', compact('data'));
    }
}