<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('avatar_path')->nullable()->after('phone');
            $table->string('employee_id', 20)->unique()->nullable()->after('avatar_path');
            $table->string('position')->nullable()->after('employee_id');
            $table->string('department')->nullable()->after('position');
            $table->timestamp('last_login_at')->nullable()->after('email_verified_at');
            $table->boolean('is_active')->default(true)->after('last_login_at');
            $table->json('preferences')->nullable()->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'avatar_path',
                'employee_id',
                'position',
                'department',
                'last_login_at',
                'is_active',
                'preferences'
            ]);
        });
    }
};
