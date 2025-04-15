<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactInfoToCarriersTable extends Migration
{
    public function up()
    {
        Schema::table('carriers', function (Blueprint $table) {
            $table->string('contact_info')->after('name');
        });
    }

    public function down()
    {
        Schema::table('carriers', function (Blueprint $table) {
            $table->dropColumn('contact_info');
        });
    }
}