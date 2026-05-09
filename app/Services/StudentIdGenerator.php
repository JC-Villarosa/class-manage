<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class StudentIdGenerator
{
    private const PREFIX = 'STU';
    private const PAD_LENGTH = 5;

    public static function generate(): string
    {
        return DB::transaction(function () {
            $last = DB::table('students')
                ->whereNotNull('custom_id')
                ->orderByDesc('id')
                ->lockForUpdate()
                ->value('custom_id');

            $next = 1;

            if ($last && preg_match('/^STU-(\d+)$/', $last, $matches)) {
                $next = (int) $matches[1] + 1;
            }

            return self::PREFIX . '-' . str_pad($next, self::PAD_LENGTH, '0', STR_PAD_LEFT);
        });
    }
}
