<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function edit()
    {
        $user = User::findOrFail(auth()->user()->id);
        return view('customer.profile', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail(auth()->user()->id);

            $alreadyExists = User::where('email', $request->email)->where('id', '!=', $user->id)->exists();
            if ($alreadyExists) {
                return redirect()->back()->with('error', 'Email sudah digunakan!');
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil memperbarui profil!');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui profil! '.$th->getMessage());
        }
    }
}
