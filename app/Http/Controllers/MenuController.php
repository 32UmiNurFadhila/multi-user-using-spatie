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
            'price' => 'required|numeric',
            'category_id' => 'required',
            'stock' => 'required|integer',
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
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer',
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

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Menu $menu)
    // {
    //     DB::beginTransaction();
    //     try {
    //         Storage::disk('public')->delete($menu->image);
    //         $menu->delete();
    //         DB::commit();

    //         return redirect()->back()->with('success', 'Barang berhasil dihapus');
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Barang gagal dihapus: ' . $th->getMessage());
    //     }
    // }

    // public function available(Menu $menu)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $menu->update(['status' => 'tersedia']);
    //         DB::commit();
    //         return redirect()->back()->with('success', 'Status menu diubah menjadi "tersedia"');
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Gagal mengubah status menu: ' . $th->getMessage());
    //     }
    // }

    // public function unavailable(Menu $menu)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $menu->update(['status' => 'kosong']);
    //         DB::commit();
    //         return redirect()->back()->with('success', 'Status menu diubah menjadi "kosong"');
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Gagal mengubah status menu: ' . $th->getMessage());
    //     }
    // }
}
