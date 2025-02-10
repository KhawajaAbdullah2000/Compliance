<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Organization extends Model
{

 public $incrementing = true;
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'country',
        'state',
        'city',
        'zip_code',
        'address',
        'status',
        'record_created_by',
        'record_creation_date',
        'record_creation_time',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'org_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'org_id');
    }
}
