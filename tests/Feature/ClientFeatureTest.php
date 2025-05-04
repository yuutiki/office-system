<?php

namespace Tests\Feature;

use App\Models\Affiliation2;
use App\Models\ClientType;
use App\Models\Corporation;
use App\Models\InstallationType;
use App\Models\TradeStatus;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientFeatureTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    protected function setUp(): void
    {
        parent::setUp(); // ← これでLaravelの初期化処理を呼び出す

        // ここでSeederを実行（マスターデータ投入など）
        $this->seed();
    }


    /** @test */
    public function 一覧画面にアクセスできる()
    {
        // ユーザー作成とログイン
        $user = User::factory()->create();

        // ログイン状態でアクセス
        $response = $this->actingAs($user)->get(route('clients.index'));

        // ステータスコード200 & ビュー確認
        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
        $response->assertViewHas(['clients', 'count']);
    }

    /** @test */
    public function 顧客登録が成功する()
    {
        $user = User::factory()->create();
        $corporation = Corporation::factory()->create(['corporation_num' => '#####']);
        $affiliation2 = Affiliation2::find(1);
        $clientType = ClientType::find(1);;
        $installationType = InstallationType::find(1);;
        $tradeStatus = TradeStatus::find(1);;

        $data = [
            'corporation_num' => $corporation->corporation_num,
            'affiliation2' => $affiliation2->id,
            'client_name' => 'テスト顧客',
            'client_kana_name' => 'テストカナ',
            'post_code' => '1234567',
            'prefecture_id' => 13,
            'address_1' => '東京都渋谷区',
            'tel' => '0312345678',
            'fax' => '0312345679',
            'profile_image' => 'default.png',
            'students' => 100,
            'distribution' => 1,
            'client_type_id' => $clientType->id,
            'installation_type_id' => $installationType->id,
            'trade_status_id' => $tradeStatus->id,
            'user_id' => $user->id,
            'memo' => 'メモ',
        ];

        $response = $this->actingAs($user)->post(route('clients.store'), $data);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', [
            'client_name' => 'テスト顧客',
            'client_kana_name' => 'テストカナ',
        ]);
    }
}
