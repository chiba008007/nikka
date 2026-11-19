<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
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

        if (strtolower($file->extension()) === 'pdf') {
            $original = Storage::disk('local')->path($saved);
            $converted = $original . '.converted.pdf';

            try {
                $process = new Process([
                    'gs',
                    '-dSAFER',
                    '-sDEVICE=pdfwrite',
                    '-dCompatibilityLevel=1.4',
                    '-dNOPAUSE',
                    '-dBATCH',
                    '-sOutputFile=' . $converted,
                    $original,
                ]);

                $process->setTimeout(120);
                $process->run();

                if (!$process->isSuccessful() ||
                    !is_file($converted) ||
                    filesize($converted) === 0) {
                    throw new RuntimeException(
                        'PDFの変換に失敗しました: ' . $process->getErrorOutput()
                    );
                }

                if (!rename($converted, $original)) {
                    throw new RuntimeException('変換後PDFの保存に失敗しました。');
                }
            } catch (\Throwable $e) {
                Storage::disk('local')->delete($saved);
                throw $e;
            } finally {
                if (is_file($converted)) {
                    unlink($converted);
                }
            }
        }

        return $saved;
    }
}
