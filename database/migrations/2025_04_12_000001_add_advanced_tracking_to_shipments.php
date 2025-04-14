<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shipments', function (Blueprint $table) {
            // GPS tracking
            $table->decimal('current_latitude', 10, 8)->nullable();
            $table->decimal('current_longitude', 11, 8)->nullable();
            $table->timestamp('last_location_update')->nullable();
            
            // Delivery confirmation
            $table->string('delivery_photo_path')->nullable();
            $table->string('signature_path')->nullable();
            $table->timestamp('delivered_at')->nullable();
            
            // QR Code
            $table->string('qr_code')->unique()->nullable();
            
            // Notification preferences
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);
            $table->string('phone_number')->nullable();
        });
    }

    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn([
                'current_latitude',
                'current_longitude',
                'last_location_update',
                'delivery_photo_path',
                'signature_path',
                'delivered_at',
                'qr_code',
                'email_notifications',
                'sms_notifications',
                'phone_number'
            ]);
        });
    }
}; 