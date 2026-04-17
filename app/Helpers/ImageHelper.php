<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Compress and resize an image before saving.
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @param int $maxWidth
     * @param int $quality
     * @return string|false Path of the saved image
     */
    public static function compressAndStore($file, $directory, $maxWidth = 1000, $quality = 75)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $image = null;

        try {
            $fileContent = file_get_contents($file->getRealPath());
            $image = imagecreatefromstring($fileContent);
        } catch (\Exception $e) {
            return false;
        }

        if (!$image) return false;

        // Ensure we handle transparency and colors properly for resizing
        imagepalettetotruecolor($image);

        // Get original dimensions
        $width = imagesx($image);
        $height = imagesy($image);

        // Calculate new dimensions if it exceeds maxWidth
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = floor($height * ($maxWidth / $width));
            
            $tempImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // For PNG/GIF transparency preservation
            if ($extension === 'png' || $extension === 'gif') {
                imagealphablending($tempImage, false);
                imagesavealpha($tempImage, true);
                $transparent = imagecolorallocatealpha($tempImage, 255, 255, 255, 127);
                imagefilledrectangle($tempImage, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($tempImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $tempImage;
        }

        // Generate unique filename
        $filename = uniqid() . '.jpg'; // Store everything as jpg for max compression
        $path = $directory . '/' . $filename;
        $tempPath = tempnam(sys_get_temp_dir(), 'img');

        // Save as JPG with quality
        imagejpeg($image, $tempPath, $quality);
        
        // Move to storage
        Storage::disk('public')->put($path, file_get_contents($tempPath));
        
        // Cleanup
        imagedestroy($image);
        unlink($tempPath);

        return $path;
    }
}
