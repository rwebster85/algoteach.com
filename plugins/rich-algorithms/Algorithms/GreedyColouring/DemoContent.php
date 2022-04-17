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

use RichWeb\Abstracts\AbstractAlgorithm;
use RichWeb\Algorithms\ContentLoader;

/**
 * @var AbstractAlgorithm $model
 * @var ContentLoader    $loader
 */

?>

<div class="demo-outer">
    <div class="demo-wrapper">
        <canvas id="demo" width="100%" height="100%">

        </canvas>
        <p class="demo-controls"><button class="button alt" id="reset-colours">Reset Colours</button></p>
        <p>Click the "Reset Colours" button above to redraw the graph using a randomised selection of available colours. While the selected colours for the graph will be different, the maximum number of colours used will always be four.</p>
    </div>
</div>
<div id="demo-result">
    <p>Result: </p>
</div>
