<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->string('id', 191)->comment('スポットID');
            $table->string('name_ja', 191)->nullable()->comment('スポット名（日本語）');
            $table->string('name_en', 191)->nullable()->comment('スポット名（英語）');
            $table->string('status', 191)->nullable()->comment('スポットステータス');
            $table->string('category', 191)->nullable()->comment('カテゴリー');
            $table->string('available_location', 191)->nullable()->comment('利用可能場所');
            $table->string('postal_code', 50)->nullable()->comment('郵便番号');
            $table->string('prefecture', 30)->nullable()->comment('都道府県');
            $table->string('address_ja', 191)->nullable()->comment('住所（日本語）');
            $table->string('address_en', 191)->nullable()->comment('住所（英語）');
            $table->string('tel', 50)->nullable()->comment('施設電話番号');
            $table->text('opening_hour')->nullable()->comment('施設営業時間');
            $table->string('ssid', 191)->nullable()->comment('SSID名称');
            $table->text('limitation')->nullable()->comment('利用時間・回数等');
            $table->text('usage')->nullable()->comment('利用手続き');
            $table->string('multi_lang', 191)->nullable()->comment('多言語対応');
            $table->text('langs')->nullable()->comment('対応言語');
            $table->string('url', 191)->nullable()->comment('ウェブサイトのURL');
            $table->string('lat', 191)->nullable()->comment('緯度');
            $table->string('lon', 191)->nullable()->comment('経度');
            $table->string('spot_code', 191)->nullable()->comment('場所情報コード');

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sources');
    }
}
