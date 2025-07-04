<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
      protected $fillable = [
        'department_id',
        'name',
    ];

    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
