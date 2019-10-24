<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLikeRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'post_id'=>'required|exists:posts,id'
        ];
    }
}
