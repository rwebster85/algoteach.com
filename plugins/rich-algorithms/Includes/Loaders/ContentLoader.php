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

namespace RichWeb\Algorithms\Loaders;

use RichWeb\Algorithms\Interfaces\ContentLoaderInterface;
use RichWeb\Algorithms\Traits\Formatting;
use function file_exists;

/**
 * Content loader includes/requires Content PHP files (views). Uses formatting traits so page content can access cleaning methods.
 * 
 * Accepts a string path to a content file and a model object.
 * 
 * Example usage:
 * 
 * ```php
 * $path = 'path/to/some/file.php';
 * 
 * $loader = new ContentLoader($path, $this);
 * $loader->loadFile();
 * ```
 * 
 * Within the content file being loaded, to reference the object passed as `$this`, use `$model`.
 * 
 * ```php
 * <?php
 * // Content file
 * // @var ContentLoader $loader
 * // @var ModelClass    $model
 * ?>
 * <div>
 *     <p><?php echo $loader->escHtml($content->someMethod()); ?></p>
 * </div>
 * ```
 * 
 * Public methods on the ContentLoader class be can accessed from within content pages by using the `$loader` variable or `$this`.
 */
final class ContentLoader implements ContentLoaderInterface
{
    use Formatting\FilePathsTrait;
    use Formatting\Strings;

    /**
     * Creates a new content loader.
     * 
     * @param string $path    The filepath of a content file to load.
     * @param object $model   The object the content file relates to.
     * @param bool   $require Whether to use require or include
     */
    public function __construct(
        private string  $path,
        private ?object $model   = null,
        private bool    $require = false
    ) {}

    /**
     * Loads the file in the ContentLoader::$path variable.
     * 
     * Also declares two local variables for use within a content file. `$loader` is this content loader, and `$model` is the object passed in the constructor.
     * 
     * @uses ContentLoader::$path
     * 
     * @return void
     */
    public function loadFile(): void
    {
        $loader = $this;
        $model  = $this->model;

        if (file_exists($this->path)) {
            if ($this->require) {
                require $this->path;
            } else {
                include $this->path;
            }
        }
    }
}
