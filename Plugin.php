<?php namespace BlackFoxIT\OpenGraph;

use System\Classes\PluginBase;
use System\Classes\SettingsManager;

/**
 * OpenGraph Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'blackfoxit.opengraph::lang.plugin.name',
            'description' => 'blackfoxit.opengraph::lang.plugin.description',
            'author'      => 'BlackFox IT',
            'icon'        => 'icon-share-alt-square' // Example icon
            // 'homepage'    => 'https://...' // Optional: Add homepage URL
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        // Future registrations (like console commands) can go here
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {
        // Code to run on plugin boot
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'BlackFoxIT\OpenGraph\Components\OpenGraphImage' => 'openGraphImage',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'blackfoxit.opengraph.access_settings' => [
                'tab'   => 'blackfoxit.opengraph::lang.permissions.tab',
                'label' => 'blackfoxit.opengraph::lang.permissions.access_settings'
            ],
        ];
    }

    /**
     * Registers settings for this plugin.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'blackfoxit.opengraph::lang.settings.label',
                'description' => 'blackfoxit.opengraph::lang.settings.description',
                'category'    => \System\Classes\SettingsManager::CATEGORY_CMS, // Use standard CMS category
                'icon'        => 'icon-image',
                'class'       => 'BlackFoxIT\OpenGraph\Models\Settings',
                'order'       => 500,
                'keywords'    => 'blackfoxit.opengraph::lang.settings.keywords',
                'permissions' => ['blackfoxit.opengraph.access_settings']
            ]
        ];
    }
} 