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

        // Create image from file
        if ($extension === 'jpg' || $extension === 'jpeg') {
            $image = imagecreatefromjpeg($file->getRealPath());
        } elseif ($extension === 'png') {
            $image = imagecreatefrompng($file->getRealPath());
            // Preserve transparency for PNG if needed, but for reports we usually prefer JPG to save space
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        } elseif ($extension === 'gif') {
            $image = imagecreatefromgif($file->getRealPath());
        }

        if (!$image) return false;

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
