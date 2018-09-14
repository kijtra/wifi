<?php

use Illuminate\Database\Seeder;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pdo = \DB::connection()->getPdo();
        $pdo->exec("TRUNCATE TABLE `sources`");
        $pdo->exec("
        LOAD DATA LOCAL
        INFILE '".resource_path('csv/jta_free_wifi.csv')."'
        INTO TABLE `sources`
        FIELDS
            TERMINATED BY ','
            ENCLOSED BY '\"'
        LINES
            TERMINATED BY '\\r\\n'
        IGNORE 1 LINES
        (
            @id,
            @name_ja,
            @name_en,
            @status,
            @category,
            @available_location,
            @postal_code,
            @prefecture,
            @address_ja,
            @address_en,
            @tel,
            @opening_hour,
            @ssid,
            @limitation,
            @usage,
            @multi_lang,
            @langs,
            @url,
            @lat,
            @lon,
            @spot_code
        )
        SET
            `id` = @id,
            `name_ja` = IF(@name_ja = '', NULL, @name_ja),
            `name_en` = IF(@name_en = '', NULL, @name_en),
            `status` = IF(@status = '', NULL, @status),
            `category` = IF(@category = '', NULL, @category),
            `available_location` = IF(@available_location = '', NULL, @available_location),
            `postal_code` = IF(@postal_code = '', NULL, @postal_code),
            `prefecture` = IF(@prefecture = '', NULL, @prefecture),
            `address_ja` = IF(@address_ja = '', NULL, @address_ja),
            `address_en` = IF(@address_en = '', NULL, @address_en),
            `tel` = IF(@tel = '', NULL, @tel),
            `opening_hour` = IF(@opening_hour = '', NULL, @opening_hour),
            `ssid` = IF(@ssid = '', NULL, @ssid),
            `limitation` = IF(@limitation = '', NULL, @limitation),
            `usage` = IF(@usage = '', NULL, @usage),
            `multi_lang` = IF(@multi_lang = '', NULL, @multi_lang),
            `langs` = IF(@langs = '', NULL, @langs),
            `url` = IF(@url = '', NULL, @url),
            `lat` = IF(@lat = '', NULL, @lat),
            `lon` = IF(@lon = '', NULL, @lon),
            `spot_code` = IF(@spot_code = '', NULL, @spot_code)
        ");
    }
}
