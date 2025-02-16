<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CustomerMenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();

        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $allMenus = $query->paginate(8);
        $menus = Menu::where('status', 'tersedia')->get();

        return view('customer.menu.index', compact('menus', 'allMenus'));
    }
}
