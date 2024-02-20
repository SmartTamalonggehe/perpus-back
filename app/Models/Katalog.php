<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    use HasFactory;

    protected $table = 'katalog';

    // belongTo classSub
    public function class_sub()
    {
        return $this->belongsTo(ClassSub::class, 'class_sub_id');
    }
}
