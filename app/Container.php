<?php

namespace App;

use Illuminate\Container\Container as ContainerManager;

class Container extends ContainerManager
{
    /**
     * @return false
     */
    public function isDownForMaintenance()
    {
        return true;
    }
}
