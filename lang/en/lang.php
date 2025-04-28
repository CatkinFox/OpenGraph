<?php return [
    'plugin' => [
        'name' => 'OpenGraph Image Generator',
        'description' => 'Generates OpenGraph images automatically for CMS pages.',
    ],
    'permissions' => [
        'access_settings' => 'Access OpenGraph generation settings',
        'tab' => 'OpenGraph',
    ],
    'settings' => [
        'label' => 'OpenGraph Settings',
        'description' => 'Manage background image, font, text placement, and colors.',
        'keywords' => 'opengraph og image social share seo font color',
        'background_image' => [
            'label' => 'Background Image',
            'comment_above' => 'Upload the base background image for your OpenGraph tags.',
            'comment' => 'Recommended size: 1200px wide by 630px high. Images with different dimensions may not display correctly.',
        ],
        'font_file' => [
            'label' => 'Font File',
            'comment_above' => 'Upload the TrueType Font (.ttf) file to use for the title text.',
            'comment' => 'Only .ttf format is supported.',
        ],
        'text_position' => [
            'label' => 'Text Position',
            'comment' => 'Select where the page title text should be placed on the image.',
            'center_top' => 'Center Top',
            'center_middle' => 'Center Middle',
            'center_bottom' => 'Center Bottom',
            'left_top' => 'Left Top',
            'left_middle' => 'Left Middle',
            'left_bottom' => 'Left Bottom',
            'right_top' => 'Right Top',
            'right_middle' => 'Right Middle',
            'right_bottom' => 'Right Bottom',
        ],
        'font_size' => [
            'label' => 'Font Size (pixels)',
            'comment' => 'Enter the font size in pixels for the overlaid text.',
        ],
        'font_color' => [
            'label' => 'Font Color',
            'comment' => 'Choose the color for the overlaid text.',
        ],
        'imagick_status' => [
            'not_found_title' => 'ImageMagick Not Found',
            'not_found_desc' => 'The required ImageMagick PHP extension (imagick) is not installed or enabled on your server. This plugin needs ImageMagick to generate images. Please install/enable it and ensure it\'s configured correctly.',
        ],
        'cache' => [
            'clear_button_label' => 'Clear Generated Image Cache',
            'clear_confirm' => 'Are you sure you want to clear all generated OpenGraph images? They will be regenerated on demand.',
            'clear_indicator' => 'Clearing Cache...',
            'clear_comment' => 'Click this button to delete all cached OpenGraph images.',
            'clear_success' => 'OpenGraph image cache cleared successfully!',
            'clear_fail' => 'Failed to delete OpenGraph image cache directory. Check permissions for storage/app/media/opengraph/generated.',
            'clear_empty' => 'OpenGraph image cache directory does not exist (already empty).',
            'clear_error' => 'An unexpected error occurred while clearing the cache. Check system logs.',
        ],
    ],
    'validation' => [
        'font_file_required' => 'Please upload a font file.',
        'font_size_required' => 'Please enter a font size.',
        'font_size_numeric' => 'Font size must be a number.',
        'font_size_min' => 'Font size must be at least 10.',
        'font_size_max' => 'Font size cannot be larger than 150.',
        'font_color_required' => 'Please select a font color.',
    ],
    'component' => [
        'name' => 'OpenGraph Image',
        'description' => 'Generates and inserts the OpenGraph image meta tag.',
        'custom_title' => [
            'title' => 'Custom Title',
            'description' => 'Optionally override the page title used for the OpenGraph image text.',
        ],
        'generation_fail_warning' => 'OpenGraph Image: Image generation failed for page: :page', // :page is a placeholder
        'config_warning' => 'OpenGraph Image: Background image or font file not configured in settings.',
    ],
]; 