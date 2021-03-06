<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReaderSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'manga_id' => 'required|exists:manga,id',
            'direction' => 'string|size:3|in:ltr,rtl,vrt'
        ];
    }
}
