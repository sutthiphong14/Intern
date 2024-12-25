<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RequestsController extends Controller
{
    /**
     * แสดงรายการคำขอทั้งหมด
     */
    public function index()
    {
        $requests = Request::orderBy('created_at', 'desc')->get();
        return view('requests.listRequests', compact('requests'));
    }

    public function create()
    {
        return view('requests.insertRequests');
    }

    public function edit($id)
    {
        $request = Request::findOrFail($id);
        return view('requests.editRequests', compact('request'));
    }

   

    /**
     * บันทึกคำขอใหม่ลงในฐานข้อมูล
     */
    public function store(HttpRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'id_employee' => 'required|string|max:255',
            'user_request' => 'required|string|max:255',
            'name_request' => 'required|string|max:255',
            'email_request' => 'required|email|max:255',
            'phone_request' => 'required|string|max:20',
            'description_request' => 'required|string',
            'password_request' => 'nullable|string|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        Request::create($request->all());

        return redirect()
            ->route('requests.list')
            ->with('success', 'เพิ่มคำขอสำเร็จ');
    }

   

    /**
     * อัปเดตข้อมูลคำขอในฐานข้อมูล
     */
    public function update(HttpRequest $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_employee' => 'required|string|max:255',
            'user_request' => 'required|string|max:255',
            'name_request' => 'required|string|max:255',
            'email_request' => 'required|email|max:255',
            'phone_request' => 'required|string|max:20',
            'description_request' => 'required|string',
            'password_request' => 'nullable|string|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $requestModel = Request::findOrFail($id);
        $requestModel->update($request->all());

        return redirect()
            ->route('requests.list')
            ->with('success', 'อัปเดตคำขอสำเร็จ');
    }

    /**
     * ลบคำขอจากฐานข้อมูล
     */
    public function destroy($id)
    {
        $request = Request::findOrFail($id);
        $request->delete();

        return redirect()
            ->route('requests.list')
            ->with('success', 'ลบคำขอสำเร็จ');
    }

    /**
     * ค้นหาคำขอ
     */
    public function search(HttpRequest $request)
    {
        $query = $request->input('query');
        
        $requests = Request::where('name_request', 'LIKE', "%{$query}%")
            ->orWhere('id_employee', 'LIKE', "%{$query}%")
            ->orWhere('email_request', 'LIKE', "%{$query}%")
            ->orWhere('phone_request', 'LIKE', "%{$query}%")
            ->get();

        return view('requests.listRequests', compact('requests'));
    }

    public function approve($id)
    {
        $request = Request::findOrFail($id);
        
        // สร้าง User ใหม่จากข้อมูล Request
        User::create([
            
            'username' => $request->user_request,
            'name' => $request->name_request,
            'email' => $request->email_request,
            'password' => Hash::make($request->password_request),
        ]);
    
        // ลบคำขอหลังจากยอมรับ
        $request->delete();
    
        // ส่งกลับไปยังหน้ารายการคำขอพร้อมข้อความสำเร็จ
        return redirect()
            ->route('requests.list')
            ->with('success', 'ยอมรับคำขอและเพิ่มผู้ใช้สำเร็จ');
    }
    



}