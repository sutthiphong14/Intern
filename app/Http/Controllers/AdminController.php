<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

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
        $data =[
            'name'=>$request->name,
            'description'=>$request->description,
            'category_id'=>$request->category_id,
            'link'=>$request->link,
        ];
      
        DB::table('newsfeeds')->insert($data);
        return redirect('/listnewsfeed');

    }

    function changenews($id){
        $status = DB::table('newsfeeds')->where('id', $id)->first();
        $data = [
            'status'=>!$status->status
        ];
        DB::table('newsfeeds')->where('id', $id)->update($data);
        return redirect()->back();
    }

    function deletenews($id){
       DB::table('newsfeeds')->where('id',$id)->delete();
       return redirect()->back();
    }
}
