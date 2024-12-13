<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('menus.index', compact('categories'));
    }
    
    public function menu_items($id)
    {
     
        $category = Category::find($id);
    
     
        $menu_items = Menu::where('category_id', $id)->get();
    

        return view('menus.menu_items', compact('category', 'menu_items'));
    }

}
