<?php

use App\Models\Traits\Metable\MetableSchema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->timestampsTz();
        });

        Schema::create('app_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->smallInteger('attempts')->unsigned();
            $table->bigInteger('reserved_at')->nullable();
            $table->bigInteger('available_at');
            $table->bigInteger('created_at');
            $table->index('reserved_at');
            $table->index('available_at');
        });

        Schema::create('app_failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestampTz('failed_at')->useCurrent();
        });

        Schema::create('app_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name')->nullable();
            $table->string('module')->nullable();
            $table->string('model')->nullable();
            $table->text('description')->nullable();
            $table->string('guard_name')->default('web');
            $table->index('module');
        });

        Schema::create('app_roles', function (Blueprint $table) {
            $table->id();
            $table->string('kd')->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('guard_name')->default('web');
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        Schema::create('app_role_permissions', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('app_roles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('app_permissions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestampTz('read_at')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('app_permissions');
        Schema::dropIfExists('app_failed_jobs');
        Schema::dropIfExists('app_jobs');
        Schema::dropIfExists('app_settings');
    }
};
