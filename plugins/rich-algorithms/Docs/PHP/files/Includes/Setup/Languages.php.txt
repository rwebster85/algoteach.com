<?php

/*
 * This file is part of Rich Algorithms.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace RichWeb\Algorithms\Setup;

use RichWeb\Algorithms\Interfaces\{
    EventSubscriberInterface,
    LanguagesInterface,
    HasRunnerInterface
};

use RichWeb\Algorithms\Traits\Formatting\{
    FilePaths,
    Strings
};

/**
 * Loads the plugin text domain, hooked into 'init'.
 */
class Languages implements LanguagesInterface, HasRunnerInterface
{
    use FilePaths;
    use Strings;

    public function __construct(
        private string $text_domain,
        private string $plugin_path,
        private EventSubscriberInterface $subscriber
    ) {}

    /**
     * Runs the class init functions not handled during construction.
     * 
     * @uses Languages::actions()
     * 
     * @return void
     */
    public function run(): void
    {
        $this->actions();
    }

    /**
     * The action hooks to set up on initialisation.
     * 
     * @uses Languages::$subscriber
     * 
     * @see EventSubscriberInterface::subscribe()
     * @see https://developer.wordpress.org/reference/hooks/init/ WP action
     * 
     * @return void
     */
    private function actions(): void
    {
        $this->subscriber->subscribe('init', [$this, 'loadTextDomain']);
    }

    /**
     * Loads the plugin text domain for translation files. Tries to find a {text-domain}-{locale}.mo file.
     * 
     * Example:
     * 
     * For the text domain 'my-plugin' a spanish language file would be named my-plugin-es_ES.mo and loaded if the site locale is Spanish.
     * 
     * Folder location of the file order or precedence:
     * 
     * 1. wp-content/languages/{text-domain}/
     * 2. {plugin_folder}/I18n/Languages/
     * 
     * @uses \RichWeb\Algorithms\Traits\Formatting\FilePaths::formatSlashes()
     * @uses \RichWeb\Algorithms\Traits\Formatting\Strings::sanitise()
     * @uses Languages::locale()
     * @uses \apply_filters() WP Function
     * @uses \unload_textdomain() WP Function
     * @uses \load_textdomain() WP Function
     * @uses \load_plugin_textdomain() WP Function
     * 
     * @return void
     */
    public function loadTextDomain(): void
    {
        $text_domain = $this->sanitise($this->text_domain);
        $path        = $this->sanitise($this->plugin_path);

        $lang_dir = $this->formatSlashes($path . '/I18n/Languages');

        $locale = $this->locale();
        $locale = apply_filters('plugin_locale', $locale, $text_domain);

        $mofile = $text_domain . '-' . $locale . '.mo';

        unload_textdomain($text_domain);

        load_textdomain($text_domain, $this->formatSlashes(WP_LANG_DIR . "/$text_domain/") . $mofile);

        load_plugin_textdomain($text_domain, false, $lang_dir);
    }

    /**
     * Gets the site locale by calling the necessary function depending on whether in the admin area or not.
     * 
     * @uses \function_exists()
     * @uses \is_admin() WP Function
     * @uses \get_user_locale() WP Function
     * @uses \get_locale() WP Function
     * 
     * @return string
     */
    private function locale(): string {
        return (is_admin() && function_exists('get_user_locale')) ? get_user_locale() : get_locale();
    }
}
