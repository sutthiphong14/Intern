<?php

namespace App\Http\Controllers;

use App\Models\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    // ฟังก์ชันแสดงรายการ slideshow ทั้งหมด
    public function showBanners()
{
    // ดึงข้อมูลแบนเนอร์ทั้งหมดจากฐานข้อมูล
    $slideshows = Slideshow::all(); // ดึงทั้งหมด
    return view('manage_images.edit_banner', compact('slideshows'));
}


public function store(Request $request)
{
    // ตรวจสอบและ Validate ข้อมูล
    $request->validate([
        'slideshow_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // ตรวจสอบไฟล์ที่อัพโหลด
        'slideshow_link' => 'nullable|url', // ตรวจสอบ URL
    ]);

    // อัพโหลดไฟล์
    $imagePath = $request->file('slideshow_image')->store('slideshow_images', 'public');

    // สร้าง Slideshow ใหม่
    Slideshow::create([
        'slideshow_image' => $imagePath,
        'slideshow_link' => $request->slideshow_link, // ถ้าผู้ใช้ไม่กรอกก็จะเป็น null
    ]);

    // Redirect ไปยังหน้า manage_images.edit_banner พร้อมข้อความสำเร็จ
    return redirect()->route('edit_banner')->with('success', 'Slideshow created successfully');
}


    // ฟังก์ชันแก้ไข slideshow
    public function edit($id)
{
    $slideshow = Slideshow::findOrFail($id);
    return response()->json($slideshow);
}


public function update(Request $request, $id)
{
    $slideshow = Slideshow::findOrFail($id);

    // ตัวอย่างการอัปเดตข้อมูล
    $slideshow->slideshow_link = $request->input('slideshow_link');
    // ลบการอัปเดต slideshow_status

    if ($request->hasFile('slideshow_image')) {
        $path = $request->file('slideshow_image')->store('slideshow_images', 'public');
        $slideshow->slideshow_image = $path;
    }

    $slideshow->save();

    return redirect()->back()->with('success', 'Slideshow updated successfully!');
}


public function destroy($id)
{
    $slideshow = Slideshow::find($id);

    if (!$slideshow) {
        return response()->json(['message' => 'ไม่พบแบนเนอร์'], 404);
    }

    // ลบไฟล์ภาพ
    if ($slideshow->slideshow_image) {
        Storage::disk('public')->delete($slideshow->slideshow_image);
    }

    // ลบแถวในฐานข้อมูล
    $slideshow->delete();

    return response()->json(['message' => 'ลบแบนเนอร์สำเร็จ'], 200);
}


}
