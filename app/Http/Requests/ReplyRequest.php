<?php

namespace App\Http\Requests;

/**
 * 验证群
 *
 * Class ReplyRequest
 * @package App\Http\Requests
 * @property $content
 */
class ReplyRequest extends Request
{
    public function rules()
    {
        return [
          "content" => 'required|min:2'
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
