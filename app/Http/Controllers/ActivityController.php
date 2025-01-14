<?php

namespace App\Http\Controllers;

use App\Models\ServeActivity;
use App\Models\PromotionActivity;
use App\Models\SpeedActivity;
use App\Models\PriceActivity;
use App\Models\typeActivity;
use Illuminate\Http\Request;


//จัดการส่วนบริการ
class ActivityController extends Controller

{
    public function index($id)
    {
        $typeId = typeActivity::where('type_id', $id)->value('type_id');
        // ดึง service_id ที่สัมพันธ์กับ typeId
        $service_id = typeActivity::where('type_id', $typeId)->value('service_id');
       
        if ($service_id) {
            // กรณี service_id มีค่า
            $data = ServeActivity::where('service_id', $service_id)->get();
        } else {
            // กรณี service_id เป็น null
            $data = ServeActivity::all();
        }
        
        
        return view('ServeActivity.ServeActivityList', compact('data','typeId'));
    }

    

    public function create()
    {
        $foreignData = PromotionActivity::all();
        return view('ServeActivity.ServeActivityInsert', compact('foreignData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            
        ]);

        ServeActivity::create($request->all());
        return view('ServeActivity.ServeActivitylist')
            ->with('success', 'Serve activity created successfully!');
    }

    public function edit($id)
    {
        $data = ServeActivity::findOrFail($id);
        $foreignData = PromotionActivity::all();
        return view('ServeActivity.ServeActivityEdit', compact('data', 'foreignData'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'promotion_id' => 'required|exists:promotion_activity,promotion_id',
        ]);

        $data = ServeActivity::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('severactivityList')
            ->with('success', 'Serve activity updated successfully!');
    }

    public function destroy($id)
    {
        $data = ServeActivity::findOrFail($id);
        $data->delete();
        return redirect()->route('severactivityList')
            ->with('success', 'Serve activity deleted successfully!');
    }



   //จัดการกิจกรรม
    public function indextype()
    {
        $data = typeActivity::all();
        return view('typeActivity.typeActivityList', compact('data'));
    }

    public function createtype()
    {
        $foreignData = TypeActivity::all();
        return view('typeActivity.typeactivitylnsert', compact('foreignData'));
    }

    public function storetype(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
            
        ]);

        TypeActivity::create($request->all());
        return redirect()->route('typeactivityList')
            ->with('success', 'Serve activity created successfully!');
    }

    public function destroytype($id)
    {
        $data = TypeActivity::findOrFail($id);
        $data->delete();
        return redirect()->route('typeactivityList')
            ->with('success', 'Serve activity deleted successfully!');
    }

    public function edittype($id)
    {
        $data = TypeActivity::findOrFail($id);
        return view('typeActivity.typeactivityEdit', compact('data'));
    }

    public function updatetype(Request $request, $id)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
            
        ]);

        $data = typeActivity::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('typeactivityList')
            ->with('success', 'Serve activity updated successfully!');
    }


    //จัดการโปรโมชัน
    public function indexpromotion($type_id,$service_id)
    {
        // ดึง service_id ที่สัมพันธ์กับ typeId
        $promotion_id = ServeActivity::where('service_id', $service_id)->value('promotion_id');
        
        $typeSelect = typeActivity::where('type_id', $type_id)
        ->update(['service_id' => $service_id]);
        if($promotion_id){
            $data = PromotionActivity::where('promotion_id', $promotion_id)->get();
        }else{
            $data = PromotionActivity::all();
        }
       
        return view('promotionActivity.promotionActivityList', compact('data' ,'service_id'));
    }

    public function  createpromotion()
    {
        $foreignData = PromotionActivity::all();
        return view('promotionActivity.promotionactivityInsert', compact('foreignData'));
    }

    public function storepromotion(Request $request)
    {
        $request->validate([
            'promotion_name' => 'required|string|max:255',
            
        ]);

        PromotionActivity::create($request->all());
        return redirect()->route('promotionactivityList')
            ->with('success', 'Serve activity created successfully!');
    }

    public function destroypromotion($id)
    {
        $data = PromotionActivity::findOrFail($id);
        $data->delete();
        return redirect()->route('promotionactivityList')
            ->with('success', 'Serve activity deleted successfully!');
    }

    public function editpromotion($id)
    {
        $data = PromotionActivity::findOrFail($id);
        return view('promotionActivity.promotionactivityEdit', compact('data'));
    }

    public function updatepromotion(Request $request, $id)
    {
        $request->validate([
            'promotion_name' => 'required|string|max:255',
            
        ]);

        $data = PromotionActivity::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('promotionactivityList')
            ->with('success', 'Serve activity updated successfully!');
    }

    //จัดการความเร็ว
    public function indexspeed($service_id,$promotion_id)
    {
        $promotionSelect = ServeActivity::where('service_id', $service_id)
        ->update(['promotion_id' => $promotion_id]);
        $data = SpeedActivity::all();
        return view('speedActivity.speedActivityList', compact('data','promotion_id'));
    }
    public function  createspeed()
    {
        $foreignData = SpeedActivity::all();
        return view('speedActivity.speedactivityInsert', compact('foreignData'));
    }

    public function storespeed(Request $request)
    {
        $request->validate([
            'speed_name' => 'required|string|max:255',
            
        ]);

        SpeedActivity::create($request->all());
        return redirect()->route('speedactivityList')
            ->with('success', 'Serve activity created successfully!');
    }

    public function destroyspeed($id)
    {
        $data = SpeedActivity::findOrFail($id);
        $data->delete();
        return redirect()->route('speedactivityList')
            ->with('success', 'Serve activity deleted successfully!');
    }

    public function editspeed($id)
    {
        $data = SpeedActivity::findOrFail($id);
        return view('speedActivity.speedactivityEdit', compact('data'));
    }

    public function updatespeed(Request $request, $id)
    {
        $request->validate([
            'speed_name' => 'required|string|max:255',
            
        ]);

        $data = speedActivity::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('speedactivityList')
            ->with('success', 'Serve activity updated successfully!');
    }

    //จัดการราคา
    public function indexprice($promotion_id,$speed_id)
    {
        $data = PriceActivity::all();
        return view('priceActivity.priceActivityList', compact('data'));
    }
    public function  creatprice()
    {
        $foreignData = PriceActivity::all();
        return view('priceActivity.priceactivityInsert', compact('foreignData'));
    }

    public function storeprice(Request $request)
    {
        $request->validate([
            'price_name' => 'required|string|max:255',
            
        ]);

        PriceActivity::create($request->all());
        return redirect()->route('priceactivityList')
            ->with('success', 'Serve activity created successfully!');
    }

    public function destroyprice($id)
    {
        $data = PriceActivity::findOrFail($id);
        $data->delete();
        return redirect()->route('priceactivityList')
            ->with('success', 'Serve activity deleted successfully!');
    }

    public function editprice($id)
    {
        $data = PriceActivity::findOrFail($id);
        return view('priceActivity.priceactivityEdit', compact('data'));
    }

    public function updateprice(Request $request, $id)
    {
        $request->validate([
            'price_name' => 'required|string|max:255',
            
        ]);

        $data = PriceActivity::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('priceactivityList')
            ->with('success', 'Serve activity updated successfully!');
    }








   
   


}