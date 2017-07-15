<?php

namespace TestProject\Application;

use TestProject\Annotation as Aop;

class Main
{
    /**
     * @Aop\Loggable()
     */
    public function doSomething()
    {

    }
}
