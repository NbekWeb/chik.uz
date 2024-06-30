<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        return response(CategoryResource::collection(Category::latest()->get()));
    }

    public function store(Request $request)
    {
        $this->checkAuth();
        $request->validate([
            'menu_id' => 'required | exists:menus,id',
            'name' => 'required | unique:categories',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $name = $request->name;
        $menu_id = $request->menu_id;
        $imagePath = $request->file('photo')->store('public/images/categories');
        $imagePath = str_replace('public/', '', $imagePath);

        $category = new Category();
        $category->photo = $imagePath;
        $category->name = $name;
        $category->menu_id = $menu_id;

        return $category->save();
    }

    public function show(Category $category)
    {
        return response(new CategoryResource($category));
    }

    public function update(Request $request, $id)
    {
        Log::info($request->all());
        $category = Category::findOrFail($id);
        $this->checkAuth();

        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'menu_id' => 'required|exists:menus,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category->name = $request->input('name');
        $category->menu_id = $request->input('menu_id');

        $oldPhotoPath = $category->photo;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/images/categories');
            $photoPath = str_replace('public/', '', $photoPath);
            $category->photo = $photoPath;

            if ($oldPhotoPath) {
                Storage::delete('public/' . $oldPhotoPath);
            }
        }

        $category->save();
        return response()->json($category);
    }


    public function destroy(Category $category)
    {
        $this->checkAuth();

        if ($category->photo) {
            $photoPath = 'public/' . $category->photo;
            if (Storage::exists($photoPath)) {
                Storage::delete($photoPath);
            } else {
                Log::warning('Photo does not exist at path: ' . $photoPath);
            }
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

    // check auth for superuser
    private function checkAuth()
    {
        if (auth()->user()->user_id !== 1) {
            return response('Forbidden', 403);
        }
    }
}
