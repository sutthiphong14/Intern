<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Newsfeed;
use Symfony\Component\HttpFoundation\BinaryFileResponse;




class AdminController extends Controller
{
    //
    function listnewsfeed()
    {
        $data = DB::table('newsfeeds')->get();
        return view('newsfeed.listnewsfeed', compact('data'));
    }

    function newsfeed()
    {
        $data = DB::table('newsfeeds')->get();
        return view('newsfeed.newsfeed', compact('data'));
    }

    function createnews(Request $request)
    {
        // การตรวจสอบข้อมูล
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'file' => 'required|file|mimes:pdf,jpg,png,xlsx|max:10240', // 10MB
        ], [
            'name.required' => 'กรุณาระบุชื่อ',
            'name.max' => 'ความยาวของชื่อไม่ควรเกิน 50 ตัวอักษร',
            'description.required' => 'กรุณาระบุคำอธิบาย',
            'file.required' => 'กรุณาระบุไฟล์',
            'file.mimes' => 'ไฟล์ต้องเป็น .pdf, .jpg, .png หรือ .xlsx',
            'file.max' => 'ขนาดไฟล์ไม่ควรเกิน 10MB',
        ]);

        // จัดการไฟล์ที่อัปโหลด
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // เก็บไฟล์ใน storage/app/public และให้ชื่อไฟล์เป็นชื่อที่ไม่ซ้ำ
            $filePath = $file->storeAs('newsfeeds', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        // ข้อมูลที่ต้องการบันทึกในฐานข้อมูล
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'file' => $filePath, // เก็บลิงก์ไฟล์ที่อัปโหลด
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // แทรกข้อมูลลงในฐานข้อมูล
        DB::table('newsfeeds')->insert($data);
        return redirect('/listnewsfeed');
    }

    function changenews($id)
    {
        $status = DB::table('newsfeeds')->where('id', $id)->first();

        if ($status) {
            $newStatus = !$status->status;
            DB::table('newsfeeds')->where('id', $id)->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'status' => $newStatus,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'ไม่พบข้อมูล',
        ]);
    }

    function deletenews($id)
    {
        $newsfeed = DB::table('newsfeeds')->where('id', $id)->first();
        if ($newsfeed && $newsfeed->file) {
            // ลบไฟล์จาก storage หากมีไฟล์
            Storage::disk('public')->delete($newsfeed->file);
        }
        DB::table('newsfeeds')->where('id', $id)->delete();
        return redirect()->back();
    }

    function editnews($id)
    {
        $oldnews = DB::table('newsfeeds')->where('id', $id)->first();
        $categories = DB::table('categories')->get(); // ดึงข้อมูล category ทั้งหมด
        return view('newsfeed.editnews', compact('oldnews', 'categories'));
    }

    function updatenews(Request $request, $id)
    {
        // การตรวจสอบข้อมูล
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'category_id' => 'required',
            'file' => 'nullable|file|mimes:pdf,jpg,png,xlsx|max:2048', // ไฟล์ไม่จำเป็นต้องอัปเดตทุกครั้ง
        ], [
            'name.required' => 'กรุณาระบุชื่อ',
            'name.max' => 'ความยาวของชื่อไม่ควรเกิน 50 ตัวอักษร',
            'description.required' => 'กรุณาระบุคำอธิบาย',
            'category_id.required' => 'กรุณาเลือกประเภท',
            'file.mimes' => 'ไฟล์ต้องเป็น .pdf, .jpg, .png หรือ .xlsx',
            'file.max' => 'ขนาดไฟล์ไม่ควรเกิน 2MB',
        ]);

        // ข้อมูลที่ต้องการอัปเดต
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'updated_at' => now(),
        ];

        // หากมีการอัปโหลดไฟล์ใหม่
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->storeAs('newsfeeds', time() . '_' . $file->getClientOriginalName(), 'public');
            $data['file'] = $filePath; // เพิ่มไฟล์ใหม่ในข้อมูล
        }

        // อัปเดตข้อมูลในฐานข้อมูล
        DB::table('newsfeeds')->where('id', $id)->update($data);
        return redirect('/listnewsfeed');
    }

    function search(Request $request)
    {
        $query = $request->input('search');
        $data = Newsfeed::when($query, function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%');
        })->get();

        return view('newsfeed.listnewsfeed', compact('data'));
    }

    public function downloadFile($id)
{
    // ดึงข้อมูลจากฐานข้อมูล
    $newsfeed = DB::table('newsfeeds')->where('id', $id)->first();

    // ตรวจสอบว่ามีข้อมูลและไฟล์อยู่จริงหรือไม่
    if ($newsfeed && Storage::disk('public')->exists($newsfeed->file)) {
        $path = storage_path('app/public/' . $newsfeed->file);
        $filename = basename($newsfeed->file); // ชื่อไฟล์ต้นฉบับ

        // ส่งคืนไฟล์ให้ดาวน์โหลด
        return response()->download($path, $filename);
    }

    // หากไม่พบไฟล์ ส่งกลับพร้อมข้อความผิดพลาด
    return redirect()->back()->with('error', 'ไม่พบไฟล์');
}



}
