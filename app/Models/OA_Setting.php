<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OA_Setting extends Model
{
    use HasFactory;

    protected $table = "OA_Setting";
    public $timestamps = false;
    protected $primaryKey = 'id';
}
