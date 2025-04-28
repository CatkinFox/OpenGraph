<?php namespace BlackFoxIT\OpenGraph\Classes;

use Imagick;
use ImagickDraw;
use ImagickPixel;
use Exception;
use Log;
use Storage;
// use Config; // Unused
// use Str; // Unused

class ImageGenerator
{
    const TARGET_WIDTH = 1200;
    const TARGET_HEIGHT = 630;
    const CACHE_DIR = 'opengraph/generated'; // Relative to storage/app/media
    // const FONT_SIZE_RATIO = 0.08; // Removed - font size is now configurable

    /**
     * Generates an OpenGraph image with text overlay and returns its public URL.
     *
     * @param string $backgroundImagePath Absolute path to the background image.
     * @param string $fontPath Absolute path to the TTF font file.
     * @param string $text The text to overlay (e.g., page title).
     * @param string $textPosition String key for text position (e.g., 'CenterMiddle').
     * @param int $fontSize The font size in pixels.
     * @param string $fontColor The font color hex code (e.g., '#FFFFFF').
     * @return string|null Public URL of the generated image, or null on failure.
     */
    public function generate(string $backgroundImagePath, string $fontPath, string $text, string $textPosition, int $fontSize, string $fontColor): ?string
    {
        try {
            // 1. Check dependencies
            if (!extension_loaded('imagick')) {
                Log::error('ImageMagick extension is not installed or enabled.');
                return null;
            }
            if (!file_exists($backgroundImagePath)) {
                 Log::error('Background image not found at path: ' . $backgroundImagePath);
                return null;
            }
             if (!file_exists($fontPath)) {
                 Log::error('Font file not found at path: ' . $fontPath);
                return null;
            }

            // 2. Prepare cache info
            $cacheKey = $this->_generateCacheKey($backgroundImagePath, $fontPath, $text, $textPosition, $fontSize, $fontColor);
            $cacheFileName = $cacheKey . '.jpg';
            $mediaRelativePath = self::CACHE_DIR . '/' . $cacheFileName;

            // 3. Check cache on MEDIA disk
            if (Storage::disk('media')->exists($mediaRelativePath)) {
                return Storage::disk('media')->url($mediaRelativePath);
            }

            // 4. Ensure cache directory exists on MEDIA disk
            $this->_ensureCacheDirectoryExists();

            // 5. Generate image
            $image = $this->_createImage($backgroundImagePath, $fontPath, $text, $textPosition, $fontSize, $fontColor);
            if (!$image) {
                return null; // Error logged in _createImage
            }

            // 6. Save to cache on MEDIA disk
            $fullCachePath = storage_path('app/media/' . $mediaRelativePath);
            $image->setImageFormat('jpeg');
            $image->setImageCompressionQuality(85);
            $writeSuccess = $image->writeImage($fullCachePath);
            
            // 7. Clean up Imagick object regardless of write success
            $this->_destroyImage($image); 
            $image = null; // Prevent potential use after destroy in exception block

            if (!$writeSuccess) {
                 Log::error('Failed to write generated image to cache: ' . $fullCachePath);
                 return null;
            }

            // 8. Return public URL from MEDIA disk
            return Storage::disk('media')->url($mediaRelativePath);

        } catch (Exception $e) {
            Log::error('Error during OpenGraph image generation: ' . $e->getMessage());
            if (isset($image)) { // $image variable might exist even if generation failed mid-way
                 $this->_destroyImage($image); // Attempt cleanup on exception
            }
            return null;
        }
    }

    /**
     * Creates the Imagick image object with text overlay.
     */
    private function _createImage(string $backgroundImagePath, string $fontPath, string $text, string $textPosition, int $fontSize, string $fontColor): ?Imagick
    {
        $image = null; // Initialize image variable
        try {
            $image = new Imagick($backgroundImagePath);
            $draw = new ImagickDraw();

            // Prepare text
            $processedText = str_replace("_", " ", $text);

            // Configure drawing settings
            $draw->setFillColor(new ImagickPixel($fontColor));
            $draw->setFont($fontPath);
            $draw->setFontSize($fontSize);
            $draw->setGravity($this->_getGravityConstant($textPosition));

            // Basic annotation without complex offset calculation
            $image->annotateImage($draw, 0, 0, 0, $processedText);

            // Resize to standard OpenGraph dimensions
            $image->resizeImage(self::TARGET_WIDTH, self::TARGET_HEIGHT, Imagick::FILTER_LANCZOS, 1, true);

            return $image;

        } catch (Exception $e) {
            Log::error('Imagick Error in _createImage: ' . $e->getMessage());
            if ($image) {
                $this->_destroyImage($image);
            }
            return null;
        }
    }

    /**
     * Maps text position string to Imagick gravity constant.
     */
    private function _getGravityConstant(string $textPosition): int
    {
        $map = [
            'CenterTop' => Imagick::GRAVITY_NORTH,
            'CenterMiddle' => Imagick::GRAVITY_CENTER,
            'CenterBottom' => Imagick::GRAVITY_SOUTH,
            'LeftTop' => Imagick::GRAVITY_NORTHWEST,
            'LeftMiddle' => Imagick::GRAVITY_WEST,
            'LeftBottom' => Imagick::GRAVITY_SOUTHWEST,
            'RightTop' => Imagick::GRAVITY_NORTHEAST,
            'RightMiddle' => Imagick::GRAVITY_EAST,
            'RightBottom' => Imagick::GRAVITY_SOUTHEAST
        ];

        return $map[$textPosition] ?? Imagick::GRAVITY_CENTER; // Default to center
    }

    /**
     * Generates a unique cache key based on input parameters.
     */
    private function _generateCacheKey(string $bgPath, string $fontPath, string $text, string $position, int $fontSize, string $fontColor): string
    {
        // Use file modification times to invalidate cache if assets change
        $bgTime = file_exists($bgPath) ? filemtime($bgPath) : '0';
        $fontTime = file_exists($fontPath) ? filemtime($fontPath) : '0';

        // Combine relevant info (including font size and color) and hash it
        $keyData = $bgPath . '|' . $bgTime . '|' . $fontPath . '|' . $fontTime . '|' . $text . '|' . $position . '|' . $fontSize . '|' . $fontColor;
        return sha1($keyData);
    }

    /**
     * Ensures the cache directory exists on the MEDIA disk.
     */
    private function _ensureCacheDirectoryExists(): void
    {
        $path = self::CACHE_DIR;
        try { // Add try-catch for directory operations
            if (!Storage::disk('media')->exists($path)) {
                 Storage::disk('media')->makeDirectory($path);
            }
        } catch (Exception $e) {
             Log::error('Could not create cache directory ['.$path.']: ' . $e->getMessage());
             // If dir creation fails, image generation will likely fail anyway
        }
    }

    /**
      * Safely destroys an Imagick object.
      */
    private function _destroyImage(?Imagick $image): void
    {
        if ($image instanceof Imagick) { // Check if it's actually an Imagick object
            try {
                $image->clear();
                $image->destroy();
            } catch (Exception $e) {
                 Log::warning('Imagick cleanup error: ' . $e->getMessage());
            }
        }
    }
} 