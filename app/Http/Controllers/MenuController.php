<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return MenuResource::collection(Menu::latest()->get());
    }
    public function store(Request $request)
    {
        $name = $request->name;
        $image = $request->image;
    }
    public function destroy(Menu $menu)
    {
        if (auth()->user()->role_id !== 1) {
            return abort(403);
        }
        return $menu->delete();
    }
}
