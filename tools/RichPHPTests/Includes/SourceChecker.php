<?php

declare(strict_types=1);

namespace RichPHPTests;

class SourceChecker
{
    /**
     * Check whether or not the executation is via command line.
     * 
     * @return bool
     */
    public static function isCli(): bool
    {
        // Code function adapted from Silver Moon, 2020
        if (defined('STDIN')) {
            return true;
        }

        if (
            empty($_SERVER['REMOTE_ADDR'])
            && !isset($_SERVER['HTTP_USER_AGENT'])
            && count($_SERVER['argv']) > 0
        ) {
            return true;
        }

        return false;
        //end of adapted code
    }
}
