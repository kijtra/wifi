<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Source;

class SpotImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spot:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import spot source data from "resources/csv/jta_free_wifi.csv"';

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
        $file = resource_path('csv/jta_free_wifi.csv');
        if (!is_file($file)) {
            $this->error(sprintf('Source file "%s" not found.', $file));
            return;
        }

        try {
            $eol = $this->getEOL($file);
            $table_sources = (new Source)->getTable();
            $pdo = \DB::connection()->getPdo();
            $pdo->exec("TRUNCATE TABLE `{$table_sources}`");
            $pdo->exec("
            LOAD DATA LOCAL
            INFILE '{$file}'
            INTO TABLE `{$table_sources}`
            FIELDS
                TERMINATED BY ','
                ENCLOSED BY '\"'
            LINES
                TERMINATED BY '".addslashes($eol)."'
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

            $this->info(sprintf('Import success from "%s".', $file));
        } catch (\Exception $e) {
            $this->error($e);
        }
    }

    /**
     * @see https://stackoverflow.com/a/45290342
     */
    protected function getEOL($file)
    {
        // first, have PHP auto-detect the line endings, like @AbraCadaver suggested:
        $ini = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', true);

        // now open the file and read a single line from it
        $file = fopen($file, 'r');
        fgets($file);

        // fgets() moves the pointer, so get the current position
        $position = ftell($file);

        // now get a couple bytes (here: 10) from around that position
        fseek($file, $position - 5);
        $data = fread($file, 10);

        // we no longer need the file
        fclose($file);

        ini_set('auto_detect_line_endings', $ini);

        // now find out how many of each type EOL there are in those 10 bytes
        // expected result is that two of these will be 0 and one will be 1
        $eols = array(
            "\r\n" => substr_count($data, "\r\n"),
            "\r" => substr_count($data, "\r"),
            "\n" => substr_count($data, "\n"),
        );

        // sort the EOL count in reverse order, so that the EOL with the highest
        // count (expected: 1) will be the first item
        arsort($eols);

        // get the first item's key
        $eol = key($eols);

        return $eol;
    }
}
