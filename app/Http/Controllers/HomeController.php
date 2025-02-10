<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsfeed; // Assuming you have a Newsfeed model
use App\Models\Slideshow;
use App\Models\Event;
use App\Models\ImageEvent;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Fetch announcements
        $data_announce = Newsfeed::where('status', true)
            ->where('categories', 'ข่าว')  // Filter by category 'ข่าว'
            ->orderBy('id', 'desc')
            ->paginate(5);

        // Fetch documents
        $data_document = Newsfeed::where('status', true)
            ->where('categories', 'เอกสาร')  // Filter by category 'เอกสาร'
            ->orderBy('id', 'desc')
            ->paginate(5);

        // Fetch forms
        $data_form = Newsfeed::where('status', true)
            ->where('categories', 'แบบฟอร์ม')  // Filter by category 'แบบฟอร์ม'
            ->orderBy('id', 'desc')
            ->paginate(5);

        // Fetch banners
        $banners = Slideshow::orderBy('slideshow_id', 'asc')->get();

        // Fetch events that are 'show'
        $album_event = Event::where('status', 'show')->get();

        // Fetch image events associated with each event
        $image_events = ImageEvent::whereIn('event_id', $album_event->pluck('event_id'))->get();

        // Get the latest Newsfeed ID for announcements
        $latestNewsId = Newsfeed::where('status', true)
            ->orderBy('id', 'desc')
            ->value('id');

        // Pass data to view
        return view('home', compact(
            'data_announce',
            'banners',
            'data_document',
            'data_form',
            'latestNewsId',
            'album_event',
            'image_events'  // Pass image events data here
        ));
    }
}
