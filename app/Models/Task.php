<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'number',
        'description',
        'created_by',
        'task_type_id',
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function type()
    {
        return $this->belongsTo(TaskType::class, 'task_type_id');
    }
    
}
