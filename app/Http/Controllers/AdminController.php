<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Newsfeed;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminController extends Controller
{
    private function logAction($action, $model, $data = null)
    {
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model' => $model,
            'data' => json_encode($data),
        ]);
    }

    function listnewsfeed()
    {
        $data = DB::table('newsfeeds')
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('newsfeed.listnewsfeed', compact('data'));
    }

    public function newsfeed(Request $request)
{
    // เริ่มต้น query
    $query = Newsfeed::where('status', true)
                     ->orderBy('id', 'desc');

    // เช็คว่ามีการค้นหาหรือไม่
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        
        // เพิ่มเงื่อนไขการค้นหาลงใน query
        $query->where('name', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
    }

    // เช็คว่ามีการเลือกหมวดหมู่หรือไม่
    if ($request->has('category') && $request->category != '') {
        $category = $request->category;
        
        // กรองข้อมูลตามหมวดหมู่ที่เลือก
        $query->where('categories', $category);
    }

    // ดึงข้อมูลทั้งหมด
    $data_all = $query->paginate(10); // ใช้ paginate เพื่อแบ่งหน้า

    $latestNewsId = Newsfeed::where('status', true)
        ->orderBy('id', 'desc')
        ->value('id');

    // ส่งข้อมูลทั้งหมดไปยัง view
    return view('newsfeed.newsfeed', compact('data_all', 'latestNewsId'));
}




    function createnews(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'categories' => 'required|in:ข่าว,เอกสาร,แบบฟอร์ม',
            'content_type' => 'required|in:file,link,youtube',
            'file' => 'nullable|required_if:content_type,file|file|mimes:pdf,jpg,png,xlsx|max:10240',
            'link' => 'nullable|required_if:content_type,link|url',
            'youtube' => 'nullable|required_if:content_type,youtube|url',
    
        ], [
            'name.required' => 'กรุณาระบุชื่อ',
            'description.required' => 'กรุณาระบุคำอธิบาย',
            'categories.required' => 'กรุณาเลือกหมวดหมู่',
            'content_type.required' => 'กรุณาเลือกประเภทข้อมูล',
            'file.required_if' => 'กรุณาอัปโหลดไฟล์เมื่อเลือกประเภทเป็นไฟล์',
            'file.mimes' => 'ไฟล์ต้องเป็น .pdf, .jpg, .png หรือ .xlsx',
            'file.max' => 'ขนาดไฟล์ไม่ควรเกิน 10MB',
            'link.required_if' => 'กรุณาระบุลิงก์เมื่อเลือกประเภทเป็นลิงก์',
            'link.url' => 'กรุณาระบุลิงก์ให้ถูกต้อง',
            'youtube.required_if' => 'กรุณาระบุลิงก์ YouTube เมื่อเลือกประเภทเป็นวิดีโอ',
            'youtube.url' => 'ลิงก์ YouTube ไม่ถูกต้อง',
        ]);
    
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'categories' => $request->categories,
            'content_type' => $request->content_type,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    
        if ($request->content_type === 'file' && $request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->storeAs('newsfeeds', time() . '_' . $file->getClientOriginalName(), 'public');
            $data['file'] = $filePath;
        } elseif ($request->content_type === 'link') {
            $data['link'] = $request->link;
        } elseif ($request->content_type === 'youtube') {
            $data['youtube'] = $request->youtube;
        }
    
        DB::table('newsfeeds')->insert($data);
    
        // Log the creation
        $this->logAction('เพิ่มเอกสาร', 'จัดการประชาสัมพันธ์', $data);
    
        return redirect('/listnewsfeed');
    }
    

public function changenews(Request $request, $id)
{
    // ค้นหาข้อมูลของข่าวจากฐานข้อมูล
    $news = DB::table('newsfeeds')->where('id', $id)->first();

    if ($news) {
        // ตรวจสอบว่าได้รับค่าใหม่สำหรับสถานะ
        $newStatus = $request->input('status') !== null ? $request->input('status') : !$news->status;

        // อัพเดตสถานะใหม่ในฐานข้อมูล
        DB::table('newsfeeds')->where('id', $id)->update(['status' => $newStatus]);

        // Log การเปลี่ยนแปลงสถานะ
        $this->logAction('chang_status', 'Newsfeed', [
            'id' => $id,
            'old_status' => $news->status,
            'new_status' => $newStatus,
        ]);

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
            Storage::disk('public')->delete($newsfeed->file);
        }

        DB::table('newsfeeds')->where('id', $id)->delete();

        // Log the deletion
        $this->logAction('deleted', 'Newsfeed', $newsfeed);

        return redirect()->back();
    }

    public function editnews($id)
{
    $oldnews = Newsfeed::findOrFail($id);
    return view('newsfeed.editnews', compact('oldnews'));
}

    public function updatenews(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'categories' => 'required|in:ข่าว,เอกสาร,แบบฟอร์ม',
            'content_type' => 'required|in:file,link,youtube',
            'file' => 'nullable|required_if:content_type,file|file|mimes:pdf,jpg,png,xlsx|max:10240',
            'link' => 'nullable|required_if:content_type,link|url',
            'youtube' => 'nullable|required_if:content_type,youtube|url',
        ]);
    
        $news = Newsfeed::findOrFail($id);
        $news->name = $request->name;
        $news->description = $request->description;
        $news->categories = $request->categories;
        $news->content_type = $request->content_type;
    
        // จัดการไฟล์ ถ้าเป็นประเภท file
        if ($request->hasFile('file')) {
            if ($news->file) {
                Storage::delete('news_files/' . $news->file);
            }
            $filePath = $request->file('file')->store('news_files', 'public');
            $news->file = $filePath;
        }
    
        // ถ้าเป็นลิงก์หรือ YouTube ให้เคลียร์ค่าที่ไม่จำเป็น
        if ($request->content_type == 'link') {
            $news->link = $request->link;
            $news->youtube = null;
        } elseif ($request->content_type == 'youtube') {
            $news->youtube = $request->youtube;
            $news->link = null;
        } else {
            $news->link = null;
            $news->youtube = null;
        }
    
        $news->save();
    
        return redirect()->route('listnewsfeed')->with('success', 'อัปเดตข่าวสำเร็จ');
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $data = DB::table('newsfeeds')
            ->where('name', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('newsfeed.listnewsfeed', compact('data'));
    }

    public function downloadFile($id)
    {
        $newsfeed = DB::table('newsfeeds')->where('id', $id)->first();

        if ($newsfeed && Storage::disk('public')->exists($newsfeed->file)) {
            $path = storage_path('app/public/' . $newsfeed->file);
            $filename = basename($newsfeed->file);

            // Log the download
            $this->logAction('downloaded', 'Newsfeed', $newsfeed);

            return response()->download($path, $filename);
        }

        return redirect()->back()->with('error', 'ไม่พบไฟล์');
    }
}