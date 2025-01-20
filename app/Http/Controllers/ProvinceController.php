<?php

namespace App\Http\Controllers;

use App\Models\ProvinceActivity;
use App\Models\ServiceCenterActivity;



use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    //จัดการข้อมูลจังหวัด
    public function indexprovince()
    {
        $data = ProvinceActivity::all();
        return view('events.provinceActivityList', compact('data'));
    }

    public function storeprovince(Request $request)
    {
        $request->validate([
            'province_name' => 'required|string|max:255',

        ]);
        ProvinceActivity::create($request->all());
        return redirect()->route('provinceactivityList')
            ->with('success', 'เพิ่มจังหวัดสำเร็จ');
    }

    public function destroyprovince($id)
    {
        $data = ProvinceActivity::findOrFail($id);
        $data->delete();
        return redirect()->route('provinceactivityList')
            ->with('success', 'ลบจังหวัดสำเร็จ');
    }

    public function updateprovince(Request $request, $id)
    {
        $request->validate([
            'province_name' => 'required|string|max:255',

        ]);
        $data = ProvinceActivity::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('provinceactivityList')
            ->with('success', 'แก้ไขจังหวัดสำเร็จ');
    }

    //จัดการข้อมูลศูนย์บริการ
    public function viewServiceCenters($province_id)
    {
        $province = ProvinceActivity::with('centers')->findOrFail($province_id);
        return view('events.viewServiceCenters', compact('province'));
    }

    public function storeServiceCenterForProvince(Request $request, $province_id)
    {
        $request->validate([
            'center_name' => 'required|string|max:255',
        ]);

        ServiceCenterActivity::create([
            'center_name' => $request->center_name,
            'province_id' => $province_id
        ]);

        return redirect()->route('province.viewServiceCenters', $province_id)
            ->with('success', 'เพิ่มศูนย์บริการสำเร็จ');
    }


    public function destroyservicecenter($id)
    {

        $data = ServiceCenterActivity::findOrFail($id);
        $data->delete();
        $id = $data->province_id;
        return redirect()->route('province.viewServiceCenters', compact('id'))
            ->with('success', 'ลบศูนย์บริการสำเร็จ');
    }

    public function updateservicecenter(Request $request, $id)
    {
        $request->validate([
            'center_name' => 'required|string|max:255',

        ]);
        $data = ServiceCenterActivity::findOrFail($id);
        $data->update($request->all());
        $id = $data->province_id;
        return redirect()->route('province.viewServiceCenters', compact('id'))
            ->with('success', 'อัปเดตศูนย์บริการสำเร็จ');
    }
}
