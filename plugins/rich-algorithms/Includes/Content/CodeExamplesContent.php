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

use RichWeb\Algorithms\CodeExamples\CodeExampleModel;
use RichWeb\Algorithms\CodeExamples\CodeExamplesModel;
use RichWeb\Algorithms\ContentLoader;

/**
 * @var CodeExamplesModel $model
 * @var ContentLoader     $loader
 */

?>

<div class="rich-algo-frontend-examples-wrap">
    <h2><i class="fas fa-code"></i> Code Examples</h2>
    <?php
        /** @var CodeExampleModel $example */
        foreach ($model->getCodeExamples() as $example) {
            echo $example->getContent();
        }
    ?>
</div>

<?php
