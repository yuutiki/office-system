<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EstimateAddress;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // $this->call(RoleSeeder::class);
        $this->call(EmployeeStatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AppMasterSeeder::class);
        $this->call(InstallationTypeSeeder::class);
        $this->call(TradeStatusSeeder::class);
        $this->call(ClientTypeSeeder::class);
        $this->call(PrefectureSeeder::class);
        $this->call(ProductMakerSeeder::class);
        $this->call(ProductSeriesSeeder::class);
        $this->call(ProductVersionSeeder::class);
        $this->call(ProductTypeSeeder::class);
        $this->call(ProductSplitTypeSeeder::class);
        $this->call(SupportTypeSeeder::class);
        $this->call(SupportTimeSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(LinkSeeder::class);
        $this->call(Affiliation1Seeder::class);
        $this->call(Affiliation2Seeder::class);
        // $this->call(Affiliation3Seeder::class);
        $this->call(AccountingPeriodSeeder::class);
        $this->call(SalesStageSeeder::class);
        $this->call(DistributionTypeSeeder::class);
        $this->call(ContactTypeSeeder::class);
        $this->call(ReportTypeSeeder::class);
        $this->call(ProjectTypeSeeder::class);
        $this->call(AccountingTypeSeeder::class);
        $this->call(ContractUpdateTypeSeeder::class);
        $this->call(ContractTypeSeeder::class);
        $this->call(ContractPartnerTypeSeeder::class);
        $this->call(ContractChangeTypeSeeder::class);
        $this->call(ContractSheetStatusSeeder::class);
        $this->call(VendorTypeSeeder::class);
        $this->call(FunctionMenuSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleGroupSeeder::class);
        $this->call(PasswordPolicySeeder::class);
        $this->call(EstimateAddressSeeder::class);
        $this->call(AppSettingSeeder::class);
        $this->call(ClientSearchModalDisplayItemSeeder::class);
        $this->call(ProjectSearchModalDisplayItemSeeder::class);
        $this->call(ProductSearchModalDisplayItemSeeder::class);
        $this->call(CorporationSearchModalDisplayItemSeeder::class);

        // $this->call(T_CorporationSeeder::class);
        $this->call(T_ClientSeeder::class);
        $this->call(T_ProjectSeeder::class);
        $this->call(T_KeepfileSeeder::class);
        $this->call(T_SmtpSettingSeeder::class);
        $this->call(T_DepartmentSeeder::class);
        $this->call(T_VendorSeeder::class);
        $this->call(T_ProductSeeder::class);
        $this->call(ClientContactCheckboxOptionsSeeder::class);
    }
}
