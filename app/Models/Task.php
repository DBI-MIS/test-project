<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'number',
        'description',
        'created_by',
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
