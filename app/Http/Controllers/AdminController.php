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
        $data_all = Newsfeed::where('status', true)
            ->orderBy('id', 'desc')
            ->paginate(10); // Use paginate to manage pagination


        $data_announce = Newsfeed::where('status', true)
            ->where('categories', 'ข่าว')  // Filter by category 'ข่าว'
            ->orderBy('id', 'desc')
            ->paginate(10); // Use paginate to manage pagination

        $data_document = Newsfeed::where('status', true)
            ->where('categories', 'เอกสาร')  // Filter by category 'ข่าว'
            ->orderBy('id', 'desc')
            ->paginate(10); // Use paginate to manage pagination

        $data_form = Newsfeed::where('status', true)
            ->where('categories', 'แบบฟอร์ม')  // Filter by category 'ข่าว'
            ->orderBy('id', 'desc')
            ->paginate(10); // Use paginate to manage pagination

        return view('newsfeed.newsfeed', compact('data_announce','data_document', 'data_form' ,'data_all'));
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

    function editnews($id)
    {
        $oldnews = DB::table('newsfeeds')->where('id', $id)->first();
        $categories = DB::table('categories')->get();
        return view('newsfeed.editnews', compact('oldnews', 'categories'));
    }

    public function updatenews(Request $request, $id)
{
    $request->validate([
        'name' => 'required|max:50',
        'description' => 'required',
        'categories' => 'required|max:255',
        'content_type' => 'required|in:file,link,youtube',
        'file' => 'required_if:content_type,file|file|mimes:pdf,jpg,png,xlsx|max:2048',
        'link' => 'nullable|required_if:content_type,link|url',
        'youtube' => 'nullable|required_if:content_type,youtube|regex:/^https:\/\/(?:www\.)?youtube\.com\/watch\?v=[\w-]+$/',
    ], [
        'name.required' => 'กรุณาระบุชื่อ',
        'description.required' => 'กรุณาระบุคำอธิบาย',
        'categories.required' => 'กรุณาระบุหมวดหมู่',
        'content_type.required' => 'กรุณาระบุประเภทข้อมูล',
        'file.required_if' => 'กรุณาอัปโหลดไฟล์เมื่อเปลี่ยนประเภทเป็นไฟล์',
        'file.mimes' => 'ไฟล์ต้องเป็น .pdf, .jpg, .png หรือ .xlsx',
        'file.max' => 'ขนาดไฟล์ไม่ควรเกิน 2MB',
        'link.required_if' => 'กรุณาระบุลิงก์เมื่อเลือกประเภทข้อมูลเป็นลิงก์',
        'link.url' => 'กรุณาระบุลิงก์ให้ถูกต้อง',
        'youtube.required_if' => 'กรุณาระบุลิงก์วิดีโอ YouTube เมื่อเลือกประเภทข้อมูลเป็นวิดีโอ',
        'youtube.regex' => 'ลิงก์ YouTube ไม่ถูกต้อง',
    ]);
    

    // Fetch old data for checking and logging purposes
    $oldData = DB::table('newsfeeds')->where('id', $id)->first();

    // Initialize the data array with new values
    $data = [
        'name' => $request->name,
        'description' => $request->description,
        'categories' => $request->categories,
        'content_type' => $request->content_type, // Keep content_type
        'updated_at' => now(),
    ];

    // Handle different content types
    if ($request->content_type === 'file') {
        // Handle file upload
        if ($request->hasFile('file')) {
            // If the old content type was 'file', delete the old file
            if ($oldData->content_type === 'file' && $oldData->file) {
                Storage::disk('public')->delete($oldData->file);
            }
            $file = $request->file('file');
            $filePath = $file->storeAs('newsfeeds', time() . '_' . $file->getClientOriginalName(), 'public');
            $data['file'] = $filePath;
        } else {
            // If no new file uploaded, set 'file' to null
            $data['file'] = null;
        }
    } elseif ($request->content_type === 'link') {
        // Handle link
        $data['link'] = $request->link;
    } elseif ($request->content_type === 'youtube') {
        // Handle YouTube link
        $data['youtube'] = $request->youtube;
    }

    // Update the news feed in the database
    DB::table('newsfeeds')->where('id', $id)->update($data);

    // Log the update action
    $this->logAction('updated', 'Newsfeed', ['old' => $oldData, 'new' => $data]);

    return redirect('/listnewsfeed');
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