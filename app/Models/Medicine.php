<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    public $fillable = [
        
        'general_description',
        'quantity',
        'unit_of_measure',
        'how_to_use',
        'warning',
        'side_effect',
        'direction'
    ];
}
