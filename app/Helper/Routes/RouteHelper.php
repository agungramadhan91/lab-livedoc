<?php

namespace App\Helper\Routes;

/**
 *
 */
class RouteHelper
{
    /**
     * Automagically Load Files Recursively
    **/
    public static function includeRouteFiles(string $folder)
    {
        // Iterate through V1 folder Recursively (RecursiveDirectoryIterator)
        $dirIterator = new \RecursiveDirectoryIterator($folder);
        $iterator = new \RecursiveIteratorIterator($dirIterator);

        // Require the file in each iteration
        while ($iterator->valid()) {
            if (!$iterator->isDot() &&
                $iterator->isFile() &&
                $iterator->isReadable() &&
                $iterator->current()->getExtension() === 'php')
            {
                require $iterator->key();
            }

            $iterator->next();
        }
    }
}
