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
        $data = DB::table('newsfeeds')->paginate(10);
        return view('newsfeed.listnewsfeed', compact('data'));
    }

    function newsfeed()
    {
        $data = DB::table('newsfeeds')->paginate(10);
        return view('newsfeed.newsfeed', compact('data'));
    }

    function createnews(Request $request)
{
    $request->validate([
    'name' => 'required|max:50',
    'description' => 'required',
    'categories' => 'required|in:ข่าว,เอกสาร,แบบฟอร์ม',
    'content_type' => 'required|in:file,link,youtube',
    'file' => 'nullable|file|mimes:pdf,jpg,png,xlsx|max:10240',
    'link' => 'nullable|url',
    'youtube' => 'nullable|url|',

], [
    'name.required' => 'กรุณาระบุชื่อ',
    'description.required' => 'กรุณาระบุคำอธิบาย',
    'categories.required' => 'กรุณาเลือกหมวดหมู่',
    'content_type.required' => 'กรุณาเลือกประเภทข้อมูล',
    'file.mimes' => 'ไฟล์ต้องเป็น .pdf, .jpg, .png หรือ .xlsx',
    'file.max' => 'ขนาดไฟล์ไม่ควรเกิน 10MB',
    'link.url' => 'กรุณาระบุลิงก์ให้ถูกต้อง',
    'youtube.regex' => 'ลิงก์ YouTube ไม่ถูกต้อง',
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

    function updatenews(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'categories' => 'required|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,png,xlsx|max:2048',
        ], [
            'name.required' => 'กรุณาระบุชื่อ',
            'name.max' => 'ความยาวของชื่อไม่ควรเกิน 50 ตัวอักษร',
            'description.required' => 'กรุณาระบุคำอธิบาย',
            'categories.required' => 'กรุณาระบุหมวดหมู่',
            'categories.max' => 'หมวดหมู่ต้องไม่เกิน 255 ตัวอักษร',
            'file.mimes' => 'ไฟล์ต้องเป็น .pdf, .jpg, .png หรือ .xlsx',
            'file.max' => 'ขนาดไฟล์ไม่ควรเกิน 2MB',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'categories' => $request->categories,
            'updated_at' => now(),
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->storeAs('newsfeeds', time() . '_' . $file->getClientOriginalName(), 'public');
            $data['file'] = $filePath;
        }

        $oldData = DB::table('newsfeeds')->where('id', $id)->first();
        DB::table('newsfeeds')->where('id', $id)->update($data);

        // Log the update
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