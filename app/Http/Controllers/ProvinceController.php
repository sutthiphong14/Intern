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
        return view('provinceActivity.provinceActivityList', compact('data'));
    }

    public function createprovince()
    {
        $foreignData = ProvinceActivity::all();
        return view('provinceActivity.provinceactivitylnsert', compact('foreignData'));
    }

    public function storeprovince(Request $request)
    {
        $request->validate([
            'province_name' => 'required|string|max:255',
            
        ]);
        ProvinceActivity::create($request->all());
        return redirect()->route('provinceactivityList')
            ->with('success', 'Serve activity created successfully!');
    }

    public function destroyprovince($id)
    {
        $data = ProvinceActivity::findOrFail($id);
        $data->delete();
        return redirect()->route('provinceactivityList')
            ->with('success', 'Serve activity deleted successfully!');
    }


    public function editprovince($id)
    {
        $data = ProvinceActivity::findOrFail($id);
        return view('provinceActivity.provinceactivityEdit', compact('data'));
    }
    public function updateprovince(Request $request, $id)
    {
        $request->validate([
            'province_name' => 'required|string|max:255',
            
        ]);
        $data = ProvinceActivity::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('provinceactivityList')
            ->with('success', 'Serve activity updated successfully!');
    }

//จัดการข้อมูลศูนย์บริการ

public function indexservicecenter()
    {
        $data = ServiceCenterActivity::all();
        return view('servicecenterActivity.servicecenterActivityList', compact('data'));
    }
    public function createservicecenter()
    {
        $foreignData = ServiceCenterActivity::all();
        return view('servicecenterActivity.servicecenteractivitylnsert', compact('foreignData'));
    }

    public function storeservicecenter(Request $request)
    {
        $request->validate([
            'center_name' => 'required|string|max:255',
            
        ]);
        ServiceCenterActivity::create($request->all());
        return redirect()->route('servicecenteractivityList')
            ->with('success', 'Serve activity created successfully!');
    }

    public function destroyservicecenter($id)
    {
        $data = ServiceCenterActivity::findOrFail($id);
        $data->delete();
        return redirect()->route('servicecenteractivityList')
            ->with('success', 'Serve activity deleted successfully!');
    }

    public function editservicecenter($id)
    {
        $data = ServiceCenterActivity::findOrFail($id);
        return view('servicecenterActivity.servicecenteractivityEdit', compact('data'));
    }
    public function updateservicecenter(Request $request, $id)
    {
        $request->validate([
            'center_name' => 'required|string|max:255',
            
        ]);
        $data = ServiceCenterActivity::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('servicecenteractivityList')
            ->with('success', 'Serve activity updated successfully!');
    }

   

public function createServiceCenterForProvince($province_id)
{
    $province = ProvinceActivity::findOrFail($province_id);
    return view('servicecenterActivity.createForProvince', compact('province'));
}



public function viewServiceCenters($province_id)
{
    $province = ProvinceActivity::with('centers')->findOrFail($province_id);
    return view('provinceActivity.viewServiceCenters', compact('province'));
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

}
