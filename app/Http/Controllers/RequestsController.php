<?php

namespace App\Http\Controllers;

use App\Models\RequestModel;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\ProvinceActivity;
use App\Models\ServiceCenterActivity;
use App\Models\User;

class RequestsController extends Controller
{
    /**
     * แสดงรายการคำขอทั้งหมด
     */
    public function index()
    {
        $requests = RequestModel::with(['province', 'serviceCenter'])->orderBy('created_at', 'desc')->get();
        return view('requests.listRequests', compact('requests'));
    }
    public function create()
    {
        $provinces = ProvinceActivity::all(); // ดึงจังหวัดทั้งหมด
        return view('requests.insertRequests', compact('provinces'));
    }

    public function edit($id)
    {
        $request = RequestModel::findOrFail($id);
        return view('requests.editRequests', compact('request'));
    }

    /**
     * บันทึกคำขอใหม่ลงในฐานข้อมูล
     */
    public function store(HttpRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'id_employee_request' => 'required|string|max:255',
            'user_request' => 'required|string|max:255',
            'name_request' => 'required|string|max:255',
            'email_request' => 'required|email|max:255|unique:requests,email_request',
            'description_request' => 'required|string',
            'department_request' => 'required|string',
            'password_request' => 'nullable|string|min:6',
            'province_id' => 'nullable|exists:province_activity,province_id',
            'center_id' => 'nullable|exists:servicecenter_activity,center_id',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        RequestModel::create($request->all());

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
            'id_employee_request' => 'required|string|max:255',
            'user_request' => 'required|string|max:255',
            'name_request' => 'required|string|max:255',
            'email_request' => 'required|email|max:255|unique:requests,email_request,' . $id . ',id_request',
            'description_request' => 'required|string',
            'department_request' => 'required|string',
            'password_request' => 'nullable|string|min:6',
            'province_id' => 'nullable|exists:province_activity,province_id',
            'center_id' => 'nullable|exists:servicecenter_activity,center_id',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $requestModel = RequestModel::findOrFail($id);
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
        $request = RequestModel::findOrFail($id);
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

        $requests = RequestModel::where('name_request', 'LIKE', "%{$query}%")
            ->orWhere('id_employee_request', 'LIKE', "%{$query}%")
            ->orWhere('email_request', 'LIKE', "%{$query}%")
            ->orWhere('user_request', 'LIKE', "%{$query}%")
            ->get();

        return view('requests.listRequests', compact('requests'));
    }

    /**
     * อนุมัติคำขอและสร้างบัญชีผู้ใช้
     */
    public function approveForm($id)
    {
        $request = RequestModel::findOrFail($id);
        return view('requests.approve', compact('request'));
    }

    public function createUser(Request $request, $id)
    {
        $requestData = RequestModel::findOrFail($id);
    
        // กำหนดค่า permission เป็น 1 ทั้งหมดโดยค่าเริ่มต้น
        $permissions = [
            'adminper_mission' => $request->has('adminper_mission') ? 1 : 0,
            'manage_users' => $request->has('manage_users') ? 1 : 0,

            'manage_dashboard' => $request->has('manage_dashboard') ? 1 : 0,
            'view_fttx' => $request->has('view_fttx') ? 1 : 0,

            'managenews_feeds' => $request->has('managenews_feeds') ? 1 : 0,

            'manage_banner' => $request->has('manage_banner') ? 1 : 0,
            'manage_imageevent' => $request->has('manage_imageevent') ? 1 : 0,

            'manage_formevent' => $request->has('manage_formevent') ? 1 : 0,
            'form_event' => $request->has('form_event') ? 1 : 0,
            'view_customer' => $request->has('view_customer') ? 1 : 0,
        ];
    
        try {
            // สร้าง User ใหม่จากข้อมูล Request
            $user = User::create([
                'username' => $requestData->user_request,
                'name' => $requestData->name_request,
                'emp_id' => $requestData->id_employee_request,
                'department' => $requestData->department_request,
                'email' => $requestData->email_request,
                'password' => Hash::make($requestData->password_request),
                'province_id' => $requestData->province_id,
                'center_id' => $requestData->center_id,
                'permission' => $permissions, // ใช้ permission ที่รับมาจากฟอร์ม
            ]);
    
            if ($user) {
                // ลบคำขอหลังจากยอมรับสำเร็จ
                $requestData->delete();
                return redirect()
                    ->route('requests.list')
                    ->with('success', 'ยอมรับคำขอและเพิ่มผู้ใช้สำเร็จ');
            } else {
                return redirect()
                    ->route('requests.list')
                    ->with('error', 'เกิดข้อผิดพลาดในการเพิ่มผู้ใช้');
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('requests.list')
                ->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }




    public function insertRequests()
    {
        $requests = User::with(['province', 'serviceCenter'])->paginate(10);
        return view('requests.insertRequests', compact('users'));
    }

    public function getProvinces()
    {
        $provinces = ProvinceActivity::all();
        return view('requests.insertRequests', compact('provinces'));
    }

    public function getCentersUserRequests(Request $request)
    {
        $province_id = $request->input('province_id');
        $centers = ServiceCenterActivity::where('province_id', $province_id)->get();

        dd($centers);
        return response()->json($centers);
    }
    public function getCentersByProvince(Request $request)
    {
        $provinceId = $request->input('province_id');

        if ($provinceId) {
            // ดึงข้อมูลศูนย์บริการที่ตรงกับ province_id
            $centers = ServiceCenterActivity::where('province_id', $provinceId)->get();

            return response()->json($centers); // ส่งกลับข้อมูลในรูปแบบ JSON
        }

        return response()->json([]); // หากไม่พบ province_id หรือข้อมูลว่าง
    }





}
