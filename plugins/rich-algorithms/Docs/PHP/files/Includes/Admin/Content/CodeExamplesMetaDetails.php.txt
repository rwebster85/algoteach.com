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

use RichWeb\Algorithms\Admin\MetaBoxes\AlgorithmCodeExamplesMetaBox;

$code_examples = $this->getCodeExamples();

/** @var AlgorithmCodeExamplesMetaBox $this **/ ?>

<div class="rich-algo-meta-outer">
    <div id="rich-algo-example-sortable">
        <?php if (!empty($code_examples) && is_array($code_examples)) {
            foreach ($code_examples as $key => $example) {
                $key = absint($key);
                $lang = $this->escHtml(($example['lang'] ?? ''));
                $code = ($example['code'] ?? '');
                $info = ($example['info'] ?? '');
                echo $this->getCodeExampleElement($key, $lang, $code, $info);
            }
        } ?>
    </div>
    <div id="rich-algo-example-sortable-add">
        <button id="rich-algo-example-add" class="button button-primary">Add New Example</button>
    </div>
</div>
