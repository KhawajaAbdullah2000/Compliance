<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubEntity extends Model
{
    use HasFactory;

    protected $table="one_link_sub_entities";
    protected $fillable = [
    'name',
    'sub_entity_type',
    'org_id',
    'department_id',
    'created_by',
];
}
