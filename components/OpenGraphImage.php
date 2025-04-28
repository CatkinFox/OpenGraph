<?php namespace BlackFoxIT\OpenGraph\Components;

use Cms\Classes\ComponentBase;
use BlackFoxIT\OpenGraph\Models\Settings;
use BlackFoxIT\OpenGraph\Classes\ImageGenerator;
use Log; // For logging errors
use Exception;
use Lang; // Added

class OpenGraphImage extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'blackfoxit.opengraph::lang.component.name',
            'description' => 'blackfoxit.opengraph::lang.component.description'
        ];
    }

    public function defineProperties()
    {
        // return []; // No properties needed initially
        return [
            'customTitle' => [
                'title'       => 'blackfoxit.opengraph::lang.component.custom_title.title',
                'description' => 'blackfoxit.opengraph::lang.component.custom_title.description',
                'type'        => 'string',
                'default'     => '',
                'showExternalParam' => false // Keep this internal to component settings if preferred
            ]
        ];
    }

    /**
     * Executed when the component is rendered on the page.
     */
    public function onRender()
    {
        // --- Remove Commenting ---
        
        try {
            // Get settings instance
            $settings = Settings::instance();

            // Get required settings
            $backgroundImage = $settings->background_image; // This is a System\Models\File object
            $fontFile = $settings->font_file; // This is a System\Models\File object
            $textPosition = $settings->text_position ?: 'CenterMiddle'; // Default if not set
            $fontSize = (int)($settings->font_size ?: 50); // Get font size, default to 50
            $fontColor = $settings->font_color ?: '#FFFFFF'; // Get font color, default to white

            // Determine the text to use (custom property or page title)
            $textToUse = $this->property('customTitle') ?: $this->page->title; 

            // Basic validation: Ensure background and font are uploaded
            if (!$backgroundImage || !$fontFile || !$backgroundImage->getLocalPath() || !$fontFile->getLocalPath()) {
                Log::info(Lang::get('blackfoxit.opengraph::lang.component.config_warning'));
                return; // Don't proceed if essential assets are missing
            }

            // Get paths
            $backgroundImagePath = $backgroundImage->getLocalPath();
            $fontPath = $fontFile->getLocalPath();

            // Instantiate the generator
            $generator = new ImageGenerator();

            // Generate the image URL
            // The generator class will handle caching internally
            $imageUrl = $generator->generate(
                $backgroundImagePath,
                $fontPath,
                $textToUse, // Use determined text
                $textPosition,
                $fontSize,
                $fontColor // Pass the font color
            );

            // // DEBUGGING: Log the actual generated URL or NULL
            // Log::debug('OpenGraph Image URL: ' . ($imageUrl ?: 'NULL')); 

            // Pass the URL to the partial (or page directly)
            if ($imageUrl) {
                $this->page['ogImageUrl'] = $imageUrl;
            } else {
                Log::warning(Lang::get('blackfoxit.opengraph::lang.component.generation_fail_warning', ['page' => $textToUse]));
            }

        } catch (Exception $ex) {
            Log::error('OpenGraph Image Component Error: ' . $ex->getMessage()); // Keep technical error in English
            // Fail silently on the frontend
        }
        
        // --- End Remove Commenting ---
    }
} 