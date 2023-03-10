<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date'  =>  'required|date',
            'title' =>  'required|max:255',
            'type'  =>  'required|in:0,1',
            'total' =>  'required|digits_between:1,11'
        ];
    }

    public function messages()
    {
        return [
            'date.required'     =>  'Tanggal wajib diisi',
            'date.date'         =>  'Tanggal tidak valid',
            'title.required'    =>  'Judul wajib diisi',
            'title.max'         =>  'Judul maksimal 255 karakter',
            'type.required'     =>  'Tipe wajib dipilih',
            'type.in'           =>  'Tipe tidak valid',
            'total.required'    =>  'Total wajib diisi',
            'total.in'          =>  'Total 1 - 11 angka',
        ];
    }
}
