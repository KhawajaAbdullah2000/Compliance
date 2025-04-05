<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoSec21 extends Model
{
    protected $table = 'iso_sec_2_1';

    protected $primaryKey = 'assessment_id';

    public $timestamps = false;

    public function selectedRiskTargets()
    {
        return $this->hasMany(ProjAssetsSelectedRiskSourceAndTarget::class, 'asset_id', 'assessment_id');
    }
}
