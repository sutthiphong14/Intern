<?php

namespace App\Http\Controllers;

use App\Models\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SlideshowController extends Controller
{
    // ฟังก์ชันแสดงรายการ slideshow ทั้งหมด
    public function showBanners()
    {
        $slideshows = Slideshow::where('slideshow_status', 1)->get(); // ดึงเฉพาะแบนเนอร์ที่เปิดใช้งาน
        return view('manage_images.edit_banner', compact('slideshows'));
    }

    public function store(Request $request)
    {
        // ตรวจสอบและ Validate ข้อมูล
        $request->validate([
            'slideshow_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // ตรวจสอบไฟล์ที่อัพโหลด
            'slideshow_link' => 'required|url', // ตรวจสอบ URL
            'slideshow_status' => 'required|boolean', // ตรวจสอบสถานะ
        ]);
    
        // อัพโหลดไฟล์
        $imagePath = $request->file('slideshow_image')->store('slideshow_images', 'public');
    
        // สร้าง Slideshow ใหม่
        Slideshow::create([
            'slideshow_image' => $imagePath,
            'slideshow_link' => $request->slideshow_link,
            'slideshow_status' => $request->slideshow_status,
        ]);
    
        // Redirect ไปยังหน้า manage_images.edit_banner พร้อมข้อความสำเร็จ
        return redirect()->route('edit_banner')->with('success', 'Slideshow created successfully');
    }

    // ฟังก์ชันแก้ไข slideshow
    public function edit($id)
    {
        $slideshow = Slideshow::findOrFail($id);
        return view('manage_images.edit_banner', compact('slideshow'));
    }

    public function update(Request $request, $id)
    {
        $slideshow = Slideshow::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'slideshow_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'slideshow_link' => 'required|url',
            'slideshow_status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('slideshow_image')) {
            // หากมีการอัพโหลดรูปใหม่
            $imagePath = $request->file('slideshow_image')->store('slideshow_images', 'public');
            $slideshow->slideshow_image = $imagePath;
        }

        // อัพเดตข้อมูล slideshow
        $slideshow->update([
            'slideshow_link' => $request->slideshow_link,
            'slideshow_status' => $request->slideshow_status,
        ]);

        return view('manage_images.edit_banner')->with('success', 'Slideshow updated successfully');
    }

    // ฟังก์ชันลบ slideshow
    public function destroy($id)
    {
        $slideshow = Slideshow::findOrFail($id);
        $slideshow->delete();

        return view('manage_images.edit_banner')->with('success', 'Slideshow deleted successfully');
    }
}
