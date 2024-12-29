<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Organization extends Model
{

    protected $primaryKey = 'org_id';
 public $incrementing = true;
    use HasFactory;
    protected $fillable = [
        'name',
        'sub_org',
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
}
