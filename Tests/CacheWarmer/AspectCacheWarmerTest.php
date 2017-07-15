<?php
/**
 * Go! AOP framework
 *
 * @copyright Copyright 2015, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Go\Symfony\GoAopBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AspectCacheWarmerTest extends WebTestCase
{
    /**
     * @test
     * @runInSeparateProcess
     */
    public function simple()
    {
        self::bootKernel();
        $this->assertTrue(true);
    }
}
