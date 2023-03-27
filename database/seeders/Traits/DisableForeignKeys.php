<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

/**
 *
 */
trait DisableForeignKeys
{
    function disableForeignKeys()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    }

    function enableForeignKeys()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
