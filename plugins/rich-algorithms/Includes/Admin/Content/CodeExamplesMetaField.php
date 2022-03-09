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

$languages = $this->supportedLanguages();

/** @var AlgorithmCodeExamplesMetaBox $this **/ ?>

<div class="rich-algo-example-wrap" id="rich-algo-example-wrap-<?php echo $key; ?>" data-example-id="<?php echo $key; ?>">
    <span title="Move Code Example" class="rich-algo-sort-button dashicons dashicons-move"></span>
    <div class="rich-algo-meta-field-wrap">
        <label class="rich-algo-meta-field-label mar-10" for="richweb_algorithm_code_examples[<?php echo $key; ?>][content]">
            Code Example #<span class="rich-algo-example-number"><?php echo ($key + 1); ?></span>
        </label>
        <textarea rows="10" id="richweb_algorithm_code_examples[<?php echo $key; ?>][content]" name="richweb_algorithm_code_examples[<?php echo $key; ?>][content]"><?php echo $code; ?></textarea>
    </div>

    <div class="rich-algo-meta-field-wrap rich-algo-meta-field-inline">
        <label class="rich-algo-meta-field-label" for="richweb_algorithm_code_examples[<?php echo $key; ?>][lang]">Language</label>
        <select class="rich-algo-admin-select width-200 richweb_algorithm_code_examples_lang" name="richweb_algorithm_code_examples[<?php echo $key; ?>][lang]" id="richweb_algorithm_code_examples[<?php echo $key; ?>][lang]">
            <option value="">— None —</option>
            <?php foreach ($languages as $language => $nicename) {
                $name = $this->escHtml($nicename);
                $selected = selected($language, $lang, false);
                echo '<option value="' . $this->escHtml($language) . '"' . $selected . '>' . $name . '</option>';
            } ?>
        </select>
    </div>

    <hr>

    <div class="rich-algo-meta-field-wrap">
        <label class="rich-algo-meta-field-label mar-10" for="richweb_algorithm_code_examples[<?php echo $key; ?>][info]">Additional information</label>
        <?php echo $this->getCodeExampleInfoEditor($info, $key); ?>
    </div>
    <hr>

    <p class="pad-top-15">
        <button class="button rich-algo-example-remove">Remove Code Example</button>
    </p>
</div>
