<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class FileUploadService
{
    public function upload(
        UploadedFile $file,
        string $directory,
        string $prefix
    ): string {
        $prefix = preg_replace('/[^A-Za-z0-9_-]/', '_', $prefix);

        $filename = $prefix . '-'
            . now()->format('YmdHis')
            . '.' . $file->extension();

        $path = "{$directory}/{$filename}";

        // 同名ファイルの上書きを防ぐ
        if (Storage::disk('local')->exists($path)) {
            throw new RuntimeException("ファイルが既に存在します: {$path}");
        }

        $saved = $file->storeAs($directory, $filename, 'local');

        if ($saved === false) {
            throw new RuntimeException('ファイルの保存に失敗しました。');
        }

        return $saved;
    }
}
