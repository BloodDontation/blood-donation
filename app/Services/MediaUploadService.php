<?php

namespace App\Services;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUploadService {

    public function upload_new_file($file, $directory)
    {
        return $file ? $file->store($directory,'public') : null;
    }

    public function delete_file($path)
    {
        return Storage::delete("public/{$path}");
    }

}
