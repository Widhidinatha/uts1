<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laundry extends Model
{
    use HasFactory;

    protected $table = "laundry";
    protected $fillable = ['laundry','type','harga'];
}
