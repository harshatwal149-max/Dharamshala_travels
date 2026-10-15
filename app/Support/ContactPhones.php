<?php

namespace App\Support;

use App\Models\Setting;

class ContactPhones
{
    public const DEFAULT_PHONE = '+91 98765 43210';

    /**
     * Additional numbers saved from Admin → Contact Information.
     *
     * @return array<int, array{label: string, number: string}>
     */
    public static function extra(): array
    {
        $rows = json_decode((string) Setting::get('extra_phones'), true);

        return collect(is_array($rows) ? $rows : [])
            ->map(fn ($row) => [
                'label'  => trim((string) ($row['label'] ?? '')),
                'number' => trim((string) ($row['number'] ?? '')),
            ])
            ->filter(fn ($row) => $row['number'] !== '')
            ->values()
            ->all();
    }

    /**
     * Main helpline first, then the additional numbers (duplicates removed).
     *
     * @return array<int, array{label: string, number: string, href: string}>
     */
    public static function all(?string $primary = null, string $primaryLabel = 'Call / WhatsApp'): array
    {
        $primary = $primary ?: (Setting::get('contact_phone') ?: self::DEFAULT_PHONE);

        return collect([['label' => $primaryLabel, 'number' => $primary]])
            ->concat(self::extra())
            ->unique(fn ($row) => self::href($row['number']))
            ->map(fn ($row) => $row + ['href' => self::href($row['number'])])
            ->values()
            ->all();
    }

    public static function href(string $number): string
    {
        return preg_replace('/[^0-9+]/', '', $number);
    }
}
