<?php

namespace Modules\Account\Repositories\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Models\User;
use Modules\HRMS\Models\EmployeeDocument;

trait DocumentRepository
{
    public function storeFile(array $data)
    {
        $document = EmployeeDocument::create(Arr::only($data, ['empl_id', 'name', 'file']));

        if ($document) {
            Auth::user()->log(
                'dokumen dengan nama ' . $document->name . ' <strong>[ID: ' . $document->id . '] telah ditambahkan</strong>', 
                EmployeeDocument::class, 
                $document->id
            );

            return $document; 
        }

        return false;
    }

    public function deleteFile($id)
    {
        $document = EmployeeDocument::findOrFail($id);
        $fileName = $document->name;

        if ($document->file && file_exists(public_path($document->file))) {
            unlink(public_path($document->file));
        }

        if ($document->delete()) {
            auth()->user()->log('dokumen dengan nama ' . $fileName . ' <strong>[ID: ' . $id . '] telah dihapus</strong>', EmployeeDocument::class, $id);
            return true;
        }

        return false;
    }
}
