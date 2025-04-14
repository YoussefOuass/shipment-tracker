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
    Schema::table('shipments', function (Blueprint $table) {
        // Example: Adding a new column 'status'
        $table->string('status')->nullable();
    });
}

public function down()
{
    Schema::table('shipments', function (Blueprint $table) {
        $table->dropColumn('status'); // Revert change if necessary
    });
}
};
