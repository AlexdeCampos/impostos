<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imposto extends Model
{
    protected $table = "imposto_produto";
    public $timestamps = false;

    use HasFactory;
}
