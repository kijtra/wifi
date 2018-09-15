<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Source;
use App\Spot;

class SpotConvert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spot:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert Spots from Source';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $table_sources = (new Source)->getTable();
            $table_spots = (new Spot)->getTable();

            $pdo = \DB::connection()->getPdo();
            $pdo->exec("
            INSERT INTO `{$table_spots}`
            (
                SELECT
                NULL AS `id`,
                1 AS `is_official`,
                `id` AS `source_id`,
                `name_ja`,
                `name_en`,
                `status`,
                `category` AS `category_ja`,
                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`category`,'バス','Bus'),'鉄道(車内)','Inside the railway car'),'港湾','Harbor'),'空港','Airport'),'観光案内所','Tourist Information Office'),'美術館・博物館・寺社仏閣','Museum/Temples'),'観光スポット（景勝地等）','Tourist attractions'),'移動中の休憩所(サービスエリア、道の駅等)','Roadside station'),'鉄道(駅構内)','Station'),'商業施設(百貨店、SC、アウトレットモール等)','Commercial facility'),'ホテル','Hotel'),'飲食・小売店','Shop'),'その他','Others') AS `category_en`,
                NULL AS `available_location_ja`,
                `available_location` AS `available_location_en`,
                CONCAT(LEFT(`postal_code`, 3), '-', RIGHT(`postal_code`, 4)) AS `postal_code`,
                `prefecture` AS `prefecture_ja`,
                NULL AS `prefecture_en`,
                `address_ja`,
                `address_en`,
                `tel`,
                `opening_hour`,
                `ssid`,
                NULL AS `limitation_ja`,
                `limitation` AS `limitation_en`,
                NULL AS `usage_ja`,
                `usage` AS `usage_en`,
                `multi_lang`,
                `langs`,
                `url`,
                GeomFromText(CONCAT('POINT(',`lon`,' ',`lat`,')')) AS `point`,
                `spot_code`,
                NOW() AS `created_at`,
                NOW() AS `updated_at`
                FROM `{$table_sources}`
                WHERE `lat` IS NOT NULL
                AND `lon` IS NOT NULL
            )
            ON DUPLICATE KEY UPDATE
            `name_ja` = VALUES(`name_ja`),
            `name_en` = VALUES(`name_en`),
            `status` = VALUES(`status`),
            `category_ja` = VALUES(`category_ja`),
            `category_en` = VALUES(`category_en`),
            `available_location_ja` = VALUES(`available_location_ja`),
            `available_location_en` = VALUES(`available_location_en`),
            `postal_code` = VALUES(`postal_code`),
            `prefecture_ja` = VALUES(`prefecture_ja`),
            `prefecture_en` = VALUES(`prefecture_en`),
            `address_ja` = VALUES(`address_ja`),
            `address_en` = VALUES(`address_en`),
            `tel` = VALUES(`tel`),
            `opening_hour` = VALUES(`opening_hour`),
            `ssid` = VALUES(`ssid`),
            `limitation_ja` = VALUES(`limitation_ja`),
            `limitation_en` = VALUES(`limitation_en`),
            `usage_ja` = VALUES(`usage_ja`),
            `usage_en` = VALUES(`usage_en`),
            `multi_lang` = VALUES(`multi_lang`),
            `langs` = VALUES(`langs`),
            `url` = VALUES(`url`),
            `point` = VALUES(`point`),
            `spot_code` = VALUES(`spot_code`),
            `updated_at` = VALUES(`updated_at`)
            ");

            $this->info('Convert success.');
        } catch (\Exception $e) {
            $this->error($e);
        }
    }
}
