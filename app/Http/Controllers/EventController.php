<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * ดึงรายการกิจกรรมทั้งหมดในรูปแบบ JSON
     */
    public function listEvents()
    {
        // ดึงข้อมูลเฉพาะ event_id และ nameevent
        $events = Event::select('event_id', 'nameevent')->get();

        return response()->json($events);
    }

    /**
     * แสดง View รายการกิจกรรม
     */
    public function showListView()
    {
        // ดึงข้อมูลกิจกรรมทั้งหมด
        $events = Event::select('event_id', 'nameevent')->get();

        return view('manage_images.list_events', compact('events'));
    }

    /**
     * บันทึกข้อมูลกิจกรรมใหม่
     */
    public function store(Request $request)
{
    $request->validate([
        'nameevent' => 'required|string|max:255',
    ]);

    Event::create([
        'nameevent' => $request->nameevent,
    ]);

    return redirect()->route('events.list')->with('success', 'เพิ่มกิจกรรมสำเร็จ!');
}

    /**
     * ดึงข้อมูลกิจกรรมพร้อมรูปภาพ
     */
    public function show($id)
    {
        // ดึงข้อมูลกิจกรรมพร้อมตาราง image_events (สมมติว่ามีความสัมพันธ์)
        $event = Event::with('images')->find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
    }
}
