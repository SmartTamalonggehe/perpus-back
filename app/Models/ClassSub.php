<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSub extends Model
{
    use HasFactory;

    // table name
    protected $table = 'class_sub';

    // relation belongs to class_umum
    public function class_umum()
    {
        return $this->belongsTo(ClassUmum::class, 'class_umum_id');
    }
}
