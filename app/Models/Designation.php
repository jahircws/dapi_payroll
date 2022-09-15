<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $table = 'designations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'designation_name',
        'is_active',
    ];
}
