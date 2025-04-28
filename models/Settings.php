<?php namespace BlackFoxIT\OpenGraph\Models;

use Model;
use October\Rain\Database\Traits\Validation;
use Storage;
use Flash;
use Log;
use Lang;

/**
 * Settings Model
 */
class Settings extends Model
{
    use Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'blackfoxit_opengraph_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    // Validation rules (will be added later)
    public $rules = [
        // background_image validation: Standard rules block upload if dimensions are wrong.
        // A non-blocking warning is better handled via comments in fields.yaml or custom backend logic if essential.
        // 'background_image' => 'image|dimensions:max_width=1200,max_height=630', 
        'font_file' => 'required', // Rely on required + fileTypes filter in fields.yaml
        'font_size' => 'required|numeric|min:10|max:150', // Validate font size
        'font_color' => 'required' // Rely on colorpicker for format, just ensure it's provided
    ];

    // Define fillable properties if needed for direct assignment
    // public $fillable = ['background_image', 'font_file', 'text_position', 'font_size', 'font_color'];

    // Define attributes for file uploads
    public $attachOne = [
        'background_image' => ['System\Models\File'],
        'font_file' => ['System\Models\File']
    ];

    // Custom validation messages
    public $customMessages = [
        'font_file.required' => 'blackfoxit.opengraph::lang.validation.font_file_required',
        'font_size.required' => 'blackfoxit.opengraph::lang.validation.font_size_required',
        'font_size.numeric' => 'blackfoxit.opengraph::lang.validation.font_size_numeric',
        'font_size.min' => 'blackfoxit.opengraph::lang.validation.font_size_min',
        'font_size.max' => 'blackfoxit.opengraph::lang.validation.font_size_max',
        'font_color.required' => 'blackfoxit.opengraph::lang.validation.font_color_required',
    ];

    // Helper function to get text position options for the dropdown
    public function getTextPositionOptions()
    {
        // Translate the options using the Lang facade
        return [
            'CenterTop' => \Lang::get('blackfoxit.opengraph::lang.settings.text_position.center_top'),
            'CenterMiddle' => \Lang::get('blackfoxit.opengraph::lang.settings.text_position.center_middle'),
            'CenterBottom' => \Lang::get('blackfoxit.opengraph::lang.settings.text_position.center_bottom'),
            'LeftTop' => \Lang::get('blackfoxit.opengraph::lang.settings.text_position.left_top'),
            'LeftMiddle' => \Lang::get('blackfoxit.opengraph::lang.settings.text_position.left_middle'),
            'LeftBottom' => \Lang::get('blackfoxit.opengraph::lang.settings.text_position.left_bottom'),
            'RightTop' => \Lang::get('blackfoxit.opengraph::lang.settings.text_position.right_top'),
            'RightMiddle' => \Lang::get('blackfoxit.opengraph::lang.settings.text_position.right_middle'),
            'RightBottom' => \Lang::get('blackfoxit.opengraph::lang.settings.text_position.right_bottom'),
        ];
    }

    /**
     * Checks if the Imagick PHP extension is loaded.
     * This can be used in the settings form to display a warning.
     * @return bool
     */
    public function isImagickAvailable(): bool
    {
        return extension_loaded('imagick');
    }

    /**
     * AJAX Handler to clear the generated image cache.
     */
    public function onClearOpengraphCache()
    {
        try {
            $cacheDir = \BlackFoxIT\OpenGraph\Classes\ImageGenerator::CACHE_DIR;
            $disk = Storage::disk('media');

            if ($disk->exists($cacheDir)) {
                if ($disk->deleteDirectory($cacheDir)) {
                    Flash::success(\Lang::get('blackfoxit.opengraph::lang.settings.cache.clear_success'));
                } else {
                    Flash::error(\Lang::get('blackfoxit.opengraph::lang.settings.cache.clear_fail'));
                }
            } else {
                Flash::info(\Lang::get('blackfoxit.opengraph::lang.settings.cache.clear_empty'));
            }
        } catch (\Exception $ex) {
            Log::error('Error clearing OpenGraph cache: ' . $ex->getMessage());
            Flash::error(\Lang::get('blackfoxit.opengraph::lang.settings.cache.clear_error'));
        }
    }

    // Set default values when settings model is first created
    public function initSettingsData()
    {
        $this->text_position = 'CenterMiddle';
        $this->font_size = 50;
        $this->font_color = '#FFFFFF';
    }
} 