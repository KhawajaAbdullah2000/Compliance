<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Organization extends Model
{

 protected $primaryKey = ['name', 'sub_org'];
 public $incrementing = false;
    use HasFactory;
}
