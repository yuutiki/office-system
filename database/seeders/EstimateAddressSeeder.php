<?php

namespace Database\Seeders;

use App\Models\EstimateAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstimateAddressSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        EstimateAddress::create([
            'estimate_address_code' => '10',
            'estimate_address_name' => '本社学園',
            'estimate_address_1' => '京都本社',
            'estimate_address_2' => '京都市中京区烏丸通り三条上る',
            'estimate_address_3' => '',
            'estimate_address_tel' => '(075)256-7585',
            'estimate_address_fax' => '(075)256-7590',
            'estimate_address_mail' => '',
            'estimate_address_url' => '',
            'project_affiliation1' => 1,
            'project_affiliation2' => 1,
            'project_affiliation3' => 2,
            'project_affiliation4' => NULL,
            'project_affiliation5' => NULL,
        ]);
        EstimateAddress::create([
            'estimate_address_code' => '11',
            'estimate_address_name' => '東京学園',
            'estimate_address_1' => '東京支社',
            'estimate_address_2' => '東京都港区芝大門2丁目10-12 KDX芝大門ビル6階',
            'estimate_address_3' => '',
            'estimate_address_tel' => '(03)5777-5201',
            'estimate_address_fax' => '(03)5777-5205',
            'estimate_address_mail' => '',
            'estimate_address_url' => '',
            'project_affiliation1' => 1,
            'project_affiliation2' => 1,
            'project_affiliation3' => 1,
            'project_affiliation4' => NULL,
            'project_affiliation5' => NULL,
        ]);
    }
}