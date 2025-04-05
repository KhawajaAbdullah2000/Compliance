<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualitativeAssetGlobalTargetObjectRiskSource extends Model
{
    protected $table = 'qualitative_asset_global_target_object_risk_source';

    protected $primaryKey = 'qualitative_asset_global_target_object_risk_source_id';

    public function selectedAssets()
    {
        return $this->hasMany(ProjAssetsSelectedRiskSourceAndTarget::class, 'target_object_foreign', 'qualitative_asset_global_target_object_risk_source_id');
    }
}
