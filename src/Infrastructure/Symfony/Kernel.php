<?php

namespace rubenrubiob\Infrastructure\Symfony;

use rubenrubiob\Infrastructure\Symfony\DependencyInjection\ValinorMapperRegisterConstructorCompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(
            new ValinorMapperRegisterConstructorCompilerPass(
                $this->getProjectDir()
            )
        );
    }
}
