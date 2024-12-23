<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function listcategories()
    {
        $categories = Category::all();
        return view('categories.listcategories', compact('categories'));
    }

    public function create()
    {
        return view('categories.insertcategories');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ], [
            'name.required' => 'กรุณากรอกชื่อหมวดหมู่',
            'name.unique' => 'ชื่อหมวดหมู่นี้มีอยู่ในระบบแล้ว'
        ]);

        Category::create($request->all());

        return redirect()->route('categories.listcategories')
            ->with('success', 'เพิ่มหมวดหมู่เรียบร้อยแล้ว');
    }

    public function edit(Category $category)
    {
        return view('categories.editcategories', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id
        ], [
            'name.required' => 'กรุณากรอกชื่อหมวดหมู่',
            'name.unique' => 'ชื่อหมวดหมู่นี้มีอยู่ในระบบแล้ว'
        ]);

        $category->update($request->all());

        return redirect()->route('categories.listcategories')
            ->with('success', 'แก้ไขหมวดหมู่เรียบร้อยแล้ว');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.listcategories')
            ->with('success', 'ลบหมวดหมู่เรียบร้อยแล้ว');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $categories = Category::where('name', 'LIKE', "%{$query}%")->get();
        
        return view('categories.listcategories', compact('categories'));
    }

    
}