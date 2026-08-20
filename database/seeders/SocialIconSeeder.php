<?php

namespace Database\Seeders;

use App\Enums\SocialIcon\PlatformEnum;
use App\Models\SocialIcon;
use Illuminate\Database\Seeder;

class SocialIconSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = PlatformEnum::cases();
        foreach ($platforms as $key => $platform) {
            SocialIcon::query()->updateOrCreate([
                'user_id' => 2,
                'platform' => $platform,
            ], [
                'url' => $platform->value,
                'order' => $key + 1,
            ]);
        }
    }
}
