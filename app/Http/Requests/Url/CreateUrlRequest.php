<?php

namespace App\Http\Requests\Url;

use Illuminate\Foundation\Http\FormRequest;

class CreateUrlRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => ['required', 'url'],
        ];
    }

    /**
     * Get the url address from the request.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->input('url');
    }
}
