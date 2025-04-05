<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualitativeAssetBasedRiskSource extends Model
{
    protected $table = 'qualitative_asset_based_risk_sources';

    protected $primaryKey = 'qualitative_asset_based_risk_sources_id';

    public function selectedAssets()
    {
        return $this->hasMany(ProjAssetsSelectedRiskSourceAndTarget::class, 'risk_source_foreign', 'qualitative_asset_based_risk_sources_id');
    }
}
