<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function store(UploadedFile $file, string $folder = 'images'): string
    {
        // Guarda en storage/app/public/{folder}
        $path = $file->store($folder, 'public');
        return $path; // guardas en DB el path relativo (ej. 'foods/abc.jpg')
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function url(?string $path): ?string
    {
        return $path ? Storage::url($path) : null;
    }
}
