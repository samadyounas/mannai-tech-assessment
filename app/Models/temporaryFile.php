<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class temporaryFile extends Model
{
    use HasFactory;
    protected $fillable = ['folder', 'fileName', 'user_id'];

}
