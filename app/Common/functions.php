<?php

namespace app\Common;


class CommonFunction
{
    public static function formatBytes(float $bytes): string
    {
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' GB';
        } elseif ($bytes >= 1) {
            return number_format($bytes, 2) . ' MB';
        } else {
            return number_format($bytes * 1024, 0) . ' KB';
        }
    }
}
