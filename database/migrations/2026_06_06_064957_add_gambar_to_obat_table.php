<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
	{
		Schema::table('obat', function (Blueprint $table) {
			$table->string('gambar')->nullable()->after('kategori_id');
		});
	}

	public function down()
	{
		Schema::table('obat', function (Blueprint $table) {
			$table->dropColumn('gambar');
		});
	}
};


// ALTER TABLE `obat` 
// ADD COLUMN `gambar` VARCHAR(255) NULL 
// AFTER `kategori_id`;