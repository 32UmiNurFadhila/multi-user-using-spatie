<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required|max:1000',
            'image' => 'required|mimes:jpeg,png,jpg|max:1024',
            'price' => 'required|integer|min:500',
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama menu wajib diisi',
            'name.max' => 'Nama menu tidak boleh lebih dari :max karakter',
            'description.required' => 'Deskripsi menu wajib diisi',
            'description.max' => 'Deskripsi menu tidak boleh lebih dari :max karakter',
            'image.required' => 'Foto menu wajib diisi',
            'image.mimes' => 'Format file harus berupa jpeg, png, atau jpg',
            'image.max' => 'Ukuran file tidak boleh lebih dari :max kb',
            'price.required' => 'Harga menu wajib diisi',
            'price.integer' => 'Harga harus berupa angka bulat',
            'price.min' => 'Harga harus lebih besar dari Rp. :min',
            'status.required' => 'Status menu wajib diisi',
        ];
    }
}
