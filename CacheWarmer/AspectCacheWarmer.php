<?php
/**
 * Go! AOP framework
 *
 * @copyright Copyright 2015, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Go\Symfony\GoAopBundle\CacheWarmer;


use Go\Core\AspectKernel;
use Go\Instrument\ClassLoading\CachePathManager;
use Go\Instrument\ClassLoading\SourceTransformingLoader;
use Go\Instrument\FileSystem\Enumerator;
use Go\Instrument\Transformer\FilterInjectorTransformer;
use Go\Symfony\GoAopBundle\Command\CacheWarmupCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Warming the cache with injected advices
 *
 * NB: in some cases hierarchy analysis can trigger "Fatal Error: class XXX not found". This is means, that there is
 * some class with unresolved parent classes. To avoid this issue, just exclude bad classes from analysis via
 * 'excludePaths' configuration option.
 */
class AspectCacheWarmer extends CacheWarmer
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var CacheWarmupCommand
     */
    protected $cacheWarmupCommand;

    public function __construct(KernelInterface $kernel, CacheWarmupCommand $cacheWarmupCommand)
    {
        $this->kernel = $kernel;
        $this->cacheWarmupCommand = $cacheWarmupCommand;
    }

    /**
     * {@inheritdoc}
     */
    public function isOptional()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function warmUp($cacheDir)
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array(
            'command' => 'cache:warmup:aop',
            '--env' => $this->kernel->getEnvironment(),
        ));

        $output = new NullOutput();

        $application->run($input, $output);
    }
}
