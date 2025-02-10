<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ImageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class EventController extends Controller
{
    /**
     * ดึงรายการกิจกรรมทั้งหมดในรูปแบบ JSON
     */
    public function listEvents()
    {
        // ดึงข้อมูลเฉพาะ event_id และ nameevent
        $events = Event::select('event_id', 'nameevent','status')->get();

        return response()->json($events);
    }

    /**
     * แสดง View รายการกิจกรรม
     */
    public function showListView()
    {
        $events = Event::orderBy('created_at', 'desc')->get(['event_id', 'nameevent', 'status']); 
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
        'status' => 'ไม่แสดง', // ค่าเริ่มต้น
    ]);

    return redirect()->route('events.list')->with('success', 'เพิ่มกิจกรรมสำเร็จ');
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


    public function destroy($id)
{
    $event = Event::find($id);

    if (!$event) {
        return response()->json(['message' => 'ไม่พบกิจกรรม'], 404);
    }

    // ลบข้อมูล
    $event->delete();

    return response()->json(['message' => 'ลบกิจกรรมสำเร็จ!']);
}

public function deleteEvent($id)
{
    $event = Event::find($id);

    if (!$event) {
        return response()->json(['message' => 'ไม่พบกิจกรรม'], 404);
    }

    $event->update(['status' => 'inactive']); // เปลี่ยนสถานะแทนการลบ

    return response()->json(['message' => 'ปิดใช้งานกิจกรรมสำเร็จ']);
}

public function updateStatus(Request $request)
{
    $eventId = $request->event_id;

    // ตั้งค่า event ที่เลือกให้เป็น "แสดง"
    Event::where('event_id', $eventId)->update(['status' => 'show']);

    // ตั้งค่า event อื่น ๆ ทั้งหมดเป็น "ไม่แสดง"
    Event::where('event_id', '!=', $eventId)->update(['status' => 'hide']);

    return response()->json(['success' => true]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'nameevent' => 'required|string|max:255',
    ]);

    // อัปเดตชื่อกิจกรรม
    $event = Event::findOrFail($id);
    $event->update([
        'nameevent' => $request->nameevent,
    ]);

    return response()->json(['success' => true]);
}

public function manageAlbumEvent($event_id)
{
    $event = Event::findOrFail($event_id);
    // ดึงข้อมูลรูปภาพที่เกี่ยวข้องกับกิจกรรม (ถ้ามี)
    $images = ImageEvent::where('event_id', $event_id)->get();

    // ส่งข้อมูลไปยัง View
    return view('manage_images.manage_album_event', compact('event', 'images'));
}

public function uploadImage(Request $request, $event_id)
{
    // ตรวจสอบว่าไฟล์ถูกอัปโหลดมาแล้ว
    $request->validate([
        'image_event' => 'required|array|min:1', // ตรวจสอบว่าอัปโหลดไฟล์มาหลายไฟล์
        'image_event.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // ตรวจสอบชนิดไฟล์
    ]);

    // รับข้อมูลไฟล์
    $images = $request->file('image_event');

    foreach ($images as $image) {
        // เก็บไฟล์ในโฟลเดอร์ album_images ของ public disk
        $imagePath = $image->store('album_images', 'public');

        // เพิ่มข้อมูลรูปภาพในฐานข้อมูล
        ImageEvent::create([
            'event_id' => $event_id,
            'image_event' => $imagePath, // บันทึก path ของไฟล์ที่อัปโหลด
        ]);
    }

    return back()->with('success', 'Images uploaded successfully.');
}

public function deleteImage($event_id, $image_id)
{
    // ค้นหา event
    $event = Event::find($event_id);
    if (!$event) {
        return response()->json(['success' => false, 'message' => 'Event not found.']);
    }

    // ค้นหารูปภาพ
    $image = ImageEvent::where('event_id', $event_id)->find($image_id);
    if (!$image) {
        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }

    // ลบไฟล์จาก storage
    if (Storage::disk('public')->exists($image->image_event)) {
        Storage::disk('public')->delete($image->image_event);
    }

    // ลบจากฐานข้อมูล
    $image->delete();

    return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
}

}
