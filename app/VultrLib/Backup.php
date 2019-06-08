<?php


/**
 * ::::: CAUTION :::: CACHE NOT ADDED.
 */

namespace vultrui\VultrLib;

class Backup extends VultrUI
{
    public function list($subid = null)
    {
        $subid = !is_null($subid) ? '?SUBID='.$subid : null;

        return $this->Request('GET', "backup/list{$subid}", true);
    }
}
