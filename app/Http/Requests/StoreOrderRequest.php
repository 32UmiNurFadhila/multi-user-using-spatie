<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'repeater-group' => 'required|array', 
            'repeater-group.*.menu_id' => 'required|exists:menus,id',  
            'repeater-group.*.quantity' => 'required|integer|min:1',  
            'note' => 'nullable|max:255',  
        ];
    }

    public function messages(): array
    {
        return [
            'repeater-group.*.menu_id.required' => 'Menu harus diisi',
            'repeater-group.*.menu_id.exists' => 'Menu tidak ada',
            'repeater-group.*.quantity.required' => 'Jumlah harus diisi',
            'repeater-group.*.quantity.integer' => 'Jumlah harus integer',
            'repeater-group.*.quantity.min' => 'Jumlah minimal :min',
            'note.max' => 'Catatan maksimal :max karakter',
        ];
    }
}
