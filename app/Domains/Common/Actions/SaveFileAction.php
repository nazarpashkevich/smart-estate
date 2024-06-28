<?php

namespace App\Domains\Common\Actions;

use Illuminate\Http\UploadedFile;

class SaveFileAction
{
    const STORAGE_PATH = 'upload';

    public function handle(UploadedFile $file): string
    {
        return $file->storeAs(static::STORAGE_PATH, $file->getClientOriginalName());
    }
}
