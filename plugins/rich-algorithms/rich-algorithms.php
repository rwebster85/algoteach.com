<?php

/**
 * Plugin Name: Rich Algorithms
 * Plugin URI: https://algoteach.com
 * Description: Displays algorithms with code examples for implementation.
 * Version: 1.0.0
 * Author: Richard Webster
 * Author URI: https://algoteach.com
 * Requires at least: 5.9
 * Tested up to: 5.9
 * Requires PHP: 8.0.0
 *
 * Text Domain: rich-algo
 * Domain Path: /I18n/Languages
 *
 * Copyright (c) 2022 Richard Webster
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace RichWeb\Algorithms;

defined('WPINC') || exit;

if (version_compare('8.0.0', PHP_VERSION, '>')) {
    add_action('admin_notices', function() {
        printf(
            '<div class="notice notice-error">' .
            '<p style="font-size: 16px;"><strong>%1s</strong> is currently not running.</p>' .
            '<p style="font-size: 16px;">This plugin requires a minimum PHP version of %2s. '.
            'You are running version %3s.</p>' .
            '</div>',
            'Rich Algorithms',
            '8.0.0',
            PHP_VERSION
        );
    });
    return;
}

define(__NAMESPACE__ . '\PLUGIN_FILE', __FILE__);

require_once 'bootstrap.php';
