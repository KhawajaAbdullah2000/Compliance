<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjAssetsSelectedRiskSourceAndTarget extends Model
{
    protected $table = 'proj_assets_selected_risk_source_and_target';

    protected $primaryKey = 'proj_ass_risk_src_target_id';

    protected $fillable = [
        'risk_source_foreign',
        'target_object_foreign',
        'project_id',
        'asset_id',
        'last_edited_by',
    ];

    public function riskSource()
    {
        return $this->belongsTo(QualitativeAssetBasedRiskSource::class, 'risk_source_foreign', 'qualitative_asset_based_risk_sources_id');
    }

    public function targetObject()
    {
        return $this->belongsTo(QualitativeAssetGlobalTargetObjectRiskSource::class, 'target_object_foreign', 'qualitative_asset_global_target_object_risk_source_id');
    }

    public function asset()
    {
        return $this->belongsTo(IsoSec21::class, 'asset_id', 'assessment_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function editedBy()
    {
        return $this->belongsTo(User::class, 'last_edited_by', 'id');
    }
}
