<?php

namespace App\Common;


class CommonFunction
{
    public static function formatBytes(float $bytes): string
    {
        if ($bytes >= 1024 * 1024 * 1024) {
            return number_format($bytes / (1024 * 1024 * 1024), 2) . ' GB';
        } elseif ($bytes >= 1024 * 1024) {
            return number_format($bytes / (1024 * 1024)) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024) . ' KB';
        } else {
            return $bytes . ' Bytes';
        }
    }
}