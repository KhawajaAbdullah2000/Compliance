<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRepository extends Model
{
    
     protected $table = 'document_repository';

    protected $fillable = [
        'organization_id',
        'name',
        'type',
        'source',
        'path',
        'last_edited_by',
        'last_edited_at',
    ];

       public function isoSec22Records()
    {
        return $this->belongsToMany(
            IsoSec22::class,
            'iso_sec_2_2_attachments',
            'document_id',
            'iso_sec_2_2_id',
            'id',
            'assessment_id'
        )->withTimestamps();
    }
}
