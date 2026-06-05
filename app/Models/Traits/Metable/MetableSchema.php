<?php

namespace App\Models\Traits\Metable;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class MetableSchema
{
    public static function create (
        string $tableName,
        string $foreignKey,
        string $foreignTable,
        string $foreignType = 'unsignedBigInteger'
    )
    {
        return Schema::create($tableName, function (Blueprint $table) use ($foreignKey, $foreignTable, $foreignType) {
            $table->increments('id');
            $table->{$foreignType}($foreignKey);
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('type')->default('null');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
            $table->unique([$foreignKey, 'key']);
            $table->foreign($foreignKey)
                ->references('id')
                ->on($foreignTable)
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
}
