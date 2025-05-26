<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(RootAdminSeeder::class);
        $this->call(PrivilegeSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(GlobalRoles::class);
        $this->call(ProjectTypes::class);
        $this->call(ProjectTypes2::class);
        $this->call(CobitProjectType::class);
        $this->call(AddInternalAuditProjectType::class);
        $this->call(CosoProjectType::class);
        $this->call(SOC2_Type2::class);
        $this->call(Organization::class);
        $this->call(Risk_Management_Frameworks::class);
        $this->call(GlobalAssetCategories::class);
        $this->call(GlobalAssetTypes::class);
        $this->call(frameworkApproachTypes::class);
        $this->call(global_risk_assessment_approach::class);
        $this->call(globalCurrency::class);
        $this->call(QualitativeAssetRiskSourcesGLobal::class);
        $this->call(QualitativeAssetTargetObjectRiskSource::class);
        $this->call(GlobalLevelofThreats::class);
        $this->call(GlobalVulnerabilityLevel::class);
        $this->call(GlobalThreatPosedByRiskSource::class);
        $this->call(ThreatDescForGlobalThreats::class);
        $this->call(GlobalLikelihoodValue::class);
        $this->call(GlobalVulnerabilityRiskAssessment::class);
        $this->call(VulnerabilityDescForGlobalVul::class);
        $this->call(QuantitativeGlobalLikelihoodScale::class);

        //$this->call(SuperUser::class);


    }
}
