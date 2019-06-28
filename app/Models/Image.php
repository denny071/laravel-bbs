<?php

namespace App\Models;

use App\Http\Requests\UserRequest;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['type', 'path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function update(UserRequest $request)
    {
        $user = $this->user();

    }
}
