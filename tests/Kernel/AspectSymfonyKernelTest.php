<?php
/**
 * Go! AOP framework
 *
 * @copyright Copyright 2015, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Go\Symfony\GoAopBundle\Tests\Kernel;

use Go\Symfony\GoAopBundle\Kernel\AspectSymfonyKernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Debug\DebugClassLoader;

/**
 * Class AspectSymfonyKernelTest
 */
class AspectSymfonyKernelTest extends TestCase
{
    /**
     * @test
     */
    public function itInitializesAspectKernel()
    {
        require_once __DIR__.'/../Fixtures/mock/DebugClassLoader.php';

        DebugClassLoader::enable();
        $this->assertTrue(DebugClassLoader::$enabled);

        AspectSymfonyKernel::getInstance()->init([
            'appDir' => __DIR__,
            'cacheDir' => sys_get_temp_dir()
        ]);

        $this->assertTrue(DebugClassLoader::$enabled);
        $this->assertEquals(['enable', 'disable', 'enable'], DebugClassLoader::$invocations);
    }
}
