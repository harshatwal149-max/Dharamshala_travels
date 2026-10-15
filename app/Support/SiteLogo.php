<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * The uploaded logo can be several MB, but the header/footer show it at ~64px.
 * A small copy (max 256px) is generated on upload and used on the website;
 * the original stays for SEO / social previews.
 */
class SiteLogo
{
    public const SMALL_SIZE = 256;

    /**
     * Save a new logo value and (re)build its small copy when needed.
     */
    public static function set(string $logo): void
    {
        $changed = $logo !== Setting::get('site_logo');

        Setting::set('site_logo', $logo);

        if ($changed || ! static::smallExists()) {
            static::refreshSmall();
        }
    }

    /**
     * Rebuild the small copy for the current logo. Returns its path, or null
     * when the logo can't be resized (external URL, SVG, ICO, already small...).
     */
    public static function refreshSmall(): ?string
    {
        $old = Setting::get('site_logo_small');
        $small = static::makeSmall((string) Setting::get('site_logo'));

        Setting::set('site_logo_small', $small ?? '');

        if ($old && $old !== $small) {
            Storage::disk('public')->delete(static::diskPath($old));
        }

        return $small;
    }

    /**
     * URL to show on the website: the small copy when it exists, else the original.
     */
    public static function url(): ?string
    {
        return Media::url(static::smallExists() ? Setting::get('site_logo_small') : Setting::get('site_logo'));
    }

    private static function smallExists(): bool
    {
        $small = Setting::get('site_logo_small');

        return filled($small) && Storage::disk('public')->exists(static::diskPath($small));
    }

    private static function diskPath(string $publicPath): string
    {
        return Str::after(ltrim($publicPath, '/'), 'storage/');
    }

    private static function makeSmall(string $logo): ?string
    {
        if (! Str::startsWith(ltrim($logo, '/'), 'storage/') || ! extension_loaded('gd')) {
            return null;
        }

        $source = Storage::disk('public')->path(static::diskPath($logo));
        $info = @getimagesize($source);

        $loaders = [
            IMAGETYPE_PNG  => 'imagecreatefrompng',
            IMAGETYPE_JPEG => 'imagecreatefromjpeg',
            IMAGETYPE_GIF  => 'imagecreatefromgif',
            IMAGETYPE_WEBP => 'imagecreatefromwebp',
        ];

        if (! $info || ! isset($loaders[$info[2]]) || ! function_exists($loaders[$info[2]])) {
            return null;
        }

        [$width, $height] = $info;
        $scale = static::SMALL_SIZE / max($width, $height);

        if ($scale >= 1) {
            return null; // Already small enough.
        }

        $image = @$loaders[$info[2]]($source);
        if (! $image) {
            return null;
        }

        $newWidth = max(1, (int) round($width * $scale));
        $newHeight = max(1, (int) round($height * $scale));

        $small = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($small, false);
        imagesavealpha($small, true);
        imagefill($small, 0, 0, imagecolorallocatealpha($small, 0, 0, 0, 127));
        imagecopyresampled($small, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Keep transparency as PNG; logos without an alpha channel compress far better as JPEG.
        $hasAlpha = static::hasTransparency($image, $width, $height, $info);
        $name = 'branding/small/' . pathinfo($source, PATHINFO_FILENAME) . '-' . static::SMALL_SIZE . ($hasAlpha ? '.png' : '.jpg');

        Storage::disk('public')->makeDirectory('branding/small');
        $target = Storage::disk('public')->path($name);

        $saved = $hasAlpha ? imagepng($small, $target, 9) : imagejpeg($small, $target, 86);

        imagedestroy($image);
        imagedestroy($small);

        return $saved ? '/storage/' . $name : null;
    }

    private static function hasTransparency(\GdImage $image, int $width, int $height, array $info): bool
    {
        if ($info[2] === IMAGETYPE_JPEG) {
            return false;
        }

        // Palette PNGs / GIFs mark one colour as transparent.
        if (imagecolortransparent($image) !== -1) {
            return true;
        }

        // Sample a grid of pixels for any non-opaque value.
        $step = max(1, (int) floor(min($width, $height) / 64));
        for ($y = 0; $y < $height; $y += $step) {
            for ($x = 0; $x < $width; $x += $step) {
                if (((imagecolorat($image, $x, $y) >> 24) & 0x7F) > 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
