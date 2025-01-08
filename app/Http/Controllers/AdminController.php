<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Newsfeed;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminController extends Controller
{
    function listnewsfeed()
{
    $data = DB::table('newsfeeds')->paginate(10); // Adjust the number per page as needed
    return view('newsfeed.listnewsfeed', compact('data'));
}

function newsfeed()
{
    $data = DB::table('newsfeeds')->paginate(10); // Adjust the number per page as needed
    return view('newsfeed.newsfeed', compact('data'));
}


    function createnews(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'file' => 'required|file|mimes:pdf,jpg,png,xlsx|max:10240',
        ], [
            'name.required' => 'กรุณาระบุชื่อ',
            'name.max' => 'ความยาวของชื่อไม่ควรเกิน 50 ตัวอักษร',
            'description.required' => 'กรุณาระบุคำอธิบาย',
            'file.required' => 'กรุณาระบุไฟล์',
            'file.mimes' => 'ไฟล์ต้องเป็น .pdf, .jpg, .png หรือ .xlsx',
            'file.max' => 'ขนาดไฟล์ไม่ควรเกิน 10MB',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->storeAs('newsfeeds', time() . '_' . $file->getClientOriginalName(), 'public');
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'file' => $filePath,
            'status' => 1, // กำหนดค่าเริ่มต้นเป็นแสดง
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('newsfeeds')->insert($data);
        return redirect('/listnewsfeed');
    }

    public function changenews($id)
    {
        $news = DB::table('newsfeeds')->where('id', $id)->first();

        if ($news) {
            $newStatus = !$news->status;
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
            Storage::disk('public')->delete($newsfeed->file);
        }
        DB::table('newsfeeds')->where('id', $id)->delete();
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
            'category_id' => 'required',
            'file' => 'nullable|file|mimes:pdf,jpg,png,xlsx|max:2048',
        ], [
            'name.required' => 'กรุณาระบุชื่อ',
            'name.max' => 'ความยาวของชื่อไม่ควรเกิน 50 ตัวอักษร',
            'description.required' => 'กรุณาระบุคำอธิบาย',
            'category_id.required' => 'กรุณาเลือกประเภท',
            'file.mimes' => 'ไฟล์ต้องเป็น .pdf, .jpg, .png หรือ .xlsx',
            'file.max' => 'ขนาดไฟล์ไม่ควรเกิน 2MB',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'updated_at' => now(),
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->storeAs('newsfeeds', time() . '_' . $file->getClientOriginalName(), 'public');
            $data['file'] = $filePath;
        }

        DB::table('newsfeeds')->where('id', $id)->update($data);
        return redirect('/listnewsfeed');
    }

    public function search(Request $request)
{
    $query = $request->input('query');
    $data = DB::table('newsfeeds')
        ->where('name', 'LIKE', "%{$query}%")
        ->paginate(10);  // ใช้ paginate แทน get()

    return view('newsfeed.listnewsfeed', compact('data'));
}

    public function downloadFile($id)
    {
        $newsfeed = DB::table('newsfeeds')->where('id', $id)->first();

        if ($newsfeed && Storage::disk('public')->exists($newsfeed->file)) {
            $path = storage_path('app/public/' . $newsfeed->file);
            $filename = basename($newsfeed->file);
            return response()->download($path, $filename);
        }

        return redirect()->back()->with('error', 'ไม่พบไฟล์');
    }

   
}
