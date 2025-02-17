<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Menu::query();

        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $menus = $query->paginate(8);
        $categories = Category::all();

        return view('admin.menu.index', compact('menus', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:1|max:10000000',
            'category_id' => 'required',
            'stock' => 'required|integer|min:1|max:10000000',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string'
        ]);
    
        DB::beginTransaction();
        try {
            $data = $request->all();
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('barang', 'public');
                $data['image'] = $imagePath;
            }
    
            Menu::create([
                'name' => $data['name'],
                'price' => $data['price'],
                'category_id' => $data['category_id'],  
                'stock' => $data['stock'],
                'image' => $data['image'] ?? null,
                'description' => $data['description'] ?? '-',
                'status' => 'tersedia'
            ]);
            
            DB::commit();
            return redirect()->route('admin.menu.index')->with('success', 'Barang berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Barang gagal ditambahkan: ' . $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('admin.menu.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:1|max:10000000',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:1|max:10000000',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('barang', 'public');
                $data['image'] = $imagePath;
                Storage::disk('public')->delete($menu->image);
            } else {
                $data['image'] = $menu->image;
            }

            $menu->update($data);
            DB::commit();

            return redirect()->route('admin.menu.index')->with('success', 'Barang berhasil diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Barang gagal diperbarui: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id); // Cari menu berdasarkan ID
        $menu->delete(); // Hapus menu

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }

}
