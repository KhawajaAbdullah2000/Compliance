<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoSec22 extends Model
{
     protected $table = 'iso_sec_2_2';
    protected $primaryKey = 'assessment_id';
    public $timestamps = false; // if true, set accordingly

    public function documents()
    {
        return $this->belongsToMany(
            DocumentRepository::class,
            'iso_sec_2_2_attachments',
            'iso_sec_2_2_id',   // pivot FK to this
            'document_id',      // pivot FK to related
            'assessment_id',    // local key
            'id'                // related key
        )->withTimestamps();
    }
}
