<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Newsfeed;

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
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'category_id' => 'required',
            'link' => 'required'

        ], [
            'name.required' => 'กรุณาระบุชื่อ',
            'name.max' => 'ความยาวของชื่อไม่ควรเกิน 50 ตัวอักษร',
            'description.required' => 'กรุณาระบุคำอธิบาย',
            'category_id.required' => 'กรุณาเลือกประเภท',
            'link.required' => 'กรุณาระบุ link file'
        ]);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'link' => $request->link,
        ];

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
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'category_id' => 'required',
            'link' => 'required'

        ], [
            'name.required' => 'กรุณาระบุชื่อ',
            'name.max' => 'ความยาวของชื่อไม่ควรเกิน 50 ตัวอักษร',
            'description.required' => 'กรุณาระบุคำอธิบาย',
            'category_id.required' => 'กรุณาเลือกประเภท',
            'link.required' => 'กรุณาระบุ link file'
        ]);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'link' => $request->link,
        ];
        DB::table('newsfeeds')->where('id', $id)->update($data);
        return redirect('/listnewsfeed');
    }
    function search(Request $request)
    {
        $query = $request->input('search');

        $data = DB::table('newsfeeds')
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('name', 'like', '%' . $query . '%');
            })
            ->get();

        return view('newsfeed.listnewsfeed', compact('data'));
    }
}
