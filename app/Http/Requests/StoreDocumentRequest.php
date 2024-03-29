<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'title' => 'nullable|string|max:255',
            'file_id' => 'required|exists:files,id',
            'document' => 'required|file',
        ];
    }
}
