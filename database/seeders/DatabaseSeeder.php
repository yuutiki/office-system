<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(EmployeeStatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(T_KeepfileSeeder::class);
        $this->call(DepartmentSeeder::class);
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
        $this->call(CompanySeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(AccountingPeriodSeeder::class);
        $this->call(SalesStageSeeder::class);
        $this->call(DistributionTypeSeeder::class);
        $this->call(ContactTypeSeeder::class);
        $this->call(ReportTypeSeeder::class);
        $this->call(ProjectTypeSeeder::class);
        $this->call(AccountingTypeSeeder::class);
        // $this->call(T_ProjectSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
