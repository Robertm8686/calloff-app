<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationPreferencesToClientsTable extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('notification_email')->nullable();
            $table->string('notification_phone')->nullable();
            $table->boolean('notify_email')->default(true);
            $table->boolean('notify_sms')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'notification_email',
                'notification_phone',
                'notify_email',
                'notify_sms',
            ]);
        });
    }
}