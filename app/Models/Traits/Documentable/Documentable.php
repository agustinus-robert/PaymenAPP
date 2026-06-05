<?php

namespace App\Models\Traits\Documentable;

use Str;
use App\Enums\DocumentTypeEnum;
use App\Models\Document;

trait Documentable
{
    /**
     * Get all of the document.
     */
    public function document()
    {
        return $this->morphOne(Document::class, 'modelable');
    }

    /**
     * Get all of the documents.
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'modelable');
    }

    /**
     * Create new empty document instance.
     */
    public function firstOrCreateDocument($label, $path)
    {
        return Document::firstOrCreate([
            'modelable_type' => get_class($this),
            'modelable_id' => $this->id
        ], [
            'type' => DocumentTypeEnum::SYSTEM,
            'label' => $label ?: Str::random(36),
            'path' => $path,
            'kd' => Str::uuid(),
            'qr' => Str::random(32)
        ]);
    }
}
