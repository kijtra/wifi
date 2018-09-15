<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_official')->default('0');
            $table->string('source_id', 191)->nullable();
            $table->string('name_ja', 191)->nullable()->comment('スポット名（日本語）');
            $table->string('name_en', 191)->nullable()->comment('スポット名（英語）');
            $table->string('status', 191)->nullable()->comment('スポットステータス');
            $table->string('category_ja', 191)->nullable()->comment('カテゴリー（日本語）');
            $table->string('category_en', 191)->nullable()->comment('カテゴリー（英語）');
            $table->string('available_location_ja', 191)->nullable()->comment('利用可能場所（日本語）');
            $table->string('available_location_en', 191)->nullable()->comment('利用可能場所（英語）');
            $table->string('postal_code', 50)->nullable()->comment('郵便番号');
            $table->string('prefecture_ja', 30)->nullable()->comment('都道府県（日本語）');
            $table->string('prefecture_en', 30)->nullable()->comment('都道府県（英語）');
            $table->string('address_ja', 191)->nullable()->comment('住所（日本語）');
            $table->string('address_en', 191)->nullable()->comment('住所（英語）');
            $table->string('tel', 50)->nullable()->comment('施設電話番号');
            $table->text('opening_hour')->nullable()->comment('施設営業時間');
            $table->string('ssid', 191)->nullable()->comment('SSID名称');
            $table->text('limitation_ja')->nullable()->comment('利用時間・回数等（日本語）');
            $table->text('limitation_en')->nullable()->comment('利用時間・回数等（英語）');
            $table->text('usage_ja')->nullable()->comment('利用手続き（日本語）');
            $table->text('usage_en')->nullable()->comment('利用手続き（英語）');
            $table->string('multi_lang', 191)->nullable()->comment('多言語対応');
            $table->text('langs')->nullable()->comment('対応言語');
            $table->string('url', 191)->nullable()->comment('ウェブサイトのURL');
            $table->point('point')->comment('位置');
            $table->string('spot_code', 191)->nullable()->comment('場所情報コード');
            $table->timestamps();

            $table->unique('source_id');
            $table->index('is_official');
            $table->index('prefecture_ja');
            $table->spatialIndex('point');
        });

        DB::statement('ALTER TABLE `spots` ADD FULLTEXT `name` (name_ja, name_en, ssid, tel)');
        DB::statement('ALTER TABLE `spots` ADD FULLTEXT `address` (address_ja, address_en)');
        DB::statement('ALTER TABLE `spots` ADD FULLTEXT `category` (category_ja, category_en, available_location_ja, available_location_en)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `spots` DROP INDEX `name`');
        DB::statement('ALTER TABLE `spots` DROP INDEX `address`');
        DB::statement('ALTER TABLE `spots` DROP INDEX `category`');
        Schema::dropIfExists('spots');
    }
}
