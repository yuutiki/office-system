<?php

namespace Database\Factories;

use App\Models\Corporation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CorporationFactory extends Factory
{
    protected $model = Corporation::class;

    public function definition()
    {
        return [
            'corporation_num' => $this->faker->unique()->numberBetween(100000, 999999),
            'corporation_name' => '学校法人 ' . $this->faker->company,
            'corporation_kana_name' => 'ガッコウホウジン ' . $this->faker->kanaName,
            'corporation_short_name' => $this->faker->company,
            'credit_limit' => $this->faker->numberBetween(100000, 5000000),
            'corporation_memo' => $this->faker->optional()->sentence,
            'corporation_post_code' => $this->generateHyphenatedPostcode(),
            'corporation_prefecture_id' => $this->faker->numberBetween(1, 47),
            'corporation_address1' => $this->faker->address,
            'is_stop_trading' => $this->faker->boolean(10),
            'stop_trading_reason' => function (array $attributes) {
                return $attributes['is_stop_trading'] ? $this->faker->sentence : null;
            },
            'invoice_num' => $this->faker->optional()->regexify('[T][0-9]{13}'),
            'invoice_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }

    private function generateHyphenatedPostcode()
    {
        $postcode = $this->faker->postcode;
        
        // 既にハイフンがある場合を考慮
        if (Str::contains($postcode, '-')) {
            return $postcode;
        }

        // 郵便番号をハイフン付きの形式に変換
        return substr($postcode, 0, 3) . '-' . substr($postcode, 3);
    }
}