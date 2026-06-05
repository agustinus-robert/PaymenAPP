<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait HasAuditLog
{
    protected static function bootHasAuditLog()
    {
        static::created(function ($model) {
            $model->logAudit('created');
        });

        static::updated(function ($model) {
            $model->logAudit('updated');
        });

        static::deleted(function ($model) {
            $model->logAudit('deleted');
        });
    }

    protected function logAudit($event)
    {
        $oldValues = null;
        $newValues = null;
        $userName = Auth::user()->name ?? 'System';
        $modelName = class_basename($this);

        if ($event === 'updated') {
            // Ambil hanya kolom yang berubah
            $newValues = $this->getDirty();
            $oldValues = array_intersect_key($this->getOriginal(), $newValues);
            $description = "User {$userName} sedang mengubah data {$modelName}";
        } elseif ($event === 'created') {
            $newValues = $this->getAttributes();
            $description = "User {$userName} sedang menambah data {$modelName}";
        } else {
            $oldValues = $this->getAttributes();
            $description = "User {$userName} sedang menghapus data {$modelName}";
        }

        AuditLog::create([
            'auditable_id'   => $this->id,
            'auditable_type' => get_class($this),
            'event'          => $event,
            'description'    => $description,
            'old_values'     => $oldValues,
            'new_values'     => $newValues,
            'user_id'        => Auth::id(),
            'url'            => request()->fullUrl(),
            'ip_address'     => request()->ip(),
        ]);
    }
}
