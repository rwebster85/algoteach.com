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

namespace RichWeb\Algorithms\Admin\MetaBoxes;

use RichWeb\Algorithms\Admin\Abstracts\AbstractMetaBox;
use RichWeb\Algorithms\Packages\AlgorithmPackageManager;
use RichWeb\Algorithms\Packages\AlgorithmPackage;
use RichWeb\Algorithms\Traits\Formatting\Strings;

/**
 * This Meta Box outputs the algorithm package selection.
 */
final class AlgorithmPackageMetaBox extends AbstractMetaBox
{
    use Strings;

    public function __construct(
        private string $main_directory,
        private AlgorithmPackageManager $algorithm_package_manager
    ) {}

    public function add(): void
    {
        add_meta_box(
            'richweb_algorithm_package',
            __('Algorithm Package', 'rich-algo'),
            [$this, 'html'],
            'richweb_algorithm',
            'side',
            'core'
        );
    }

    public function html(\WP_Post $post): void
    {
        wp_nonce_field('_richweb_algorithm_package_nonce', 'richweb_algorithm_package_nonce');

        $post_id = $post->ID;

        $packages = $this->algorithm_package_manager->getPackages();

        $current_package = get_post_meta($post_id, 'richweb_algorithm_package', true); ?>

        <p class="rich-algo-wl-meta-desc"><?php esc_html_e('Select the algorithm package for this page.', 'rich-algo'); ?></p>

        <div class="rich-algo-meta-field-wrap">
            <select class="rich-algo-admin-select richweb_algorithm_package" name="richweb_algorithm_package" id="richweb_algorithm_package">
                <option value="">— None —</option>
                <?php
                /** @var AlgorithmPackage $package */
                foreach ($packages as $name => $package) {
                    $name = $this->escHtml($name);
                    $selected = selected($name, $current_package, false);
                    echo '<option value="' . $name . '"' . $selected . '>' . $this->escHtml($package->getName()) . '</option>';
                } ?>
            </select>
        </div>

        <?php
    }

    public function save(int $post_id): void
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        if (!isset($_POST['richweb_algorithm_package_nonce']) || !wp_verify_nonce($_POST['richweb_algorithm_package_nonce'], '_richweb_algorithm_package_nonce')) return;

        if (!current_user_can('update_core', $post_id)) return;

        $package = isset($_POST['richweb_algorithm_package'])
        ? $this->sanitise($_POST['richweb_algorithm_package'])
        : '';

        if (!empty($package)) {
            update_post_meta($post_id, 'richweb_algorithm_package', $package);
        } else {
            update_post_meta($post_id, 'richweb_algorithm_package', null);
        }
    }
}
