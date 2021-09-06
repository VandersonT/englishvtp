<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_on extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_on';
}
