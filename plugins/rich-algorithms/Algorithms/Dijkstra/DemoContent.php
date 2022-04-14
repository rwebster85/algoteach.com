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

use const RichWeb\Algorithms\PLUGIN_FILE;

/**
 * @var AbstractAlgorithm $model
 * @var ContentLoader    $loader
 */

$demo_url = esc_url(plugins_url('/Algorithms/Dijkstra/Example/index.php', PLUGIN_FILE));

?>

<div class="demo-outer">
    <div class="demo-wrapper" id="demo-wrapper">
        <iframe src="<?php echo $demo_url; ?>" width="100%" height="600" style="border:1px solid #ddd;"></iframe>
    </div>
</div>
<div id="demo-result">
    <p>Shortest Path: </p>
</div>
