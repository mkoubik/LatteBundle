<?php

class TestKernel extends Symfony\Component\HttpKernel\Kernel
{
    public function registerBundles()
    {
        return array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new LatteBundle\LatteBundle(),
            new TestingBundle(),
        );
    }

    public function registerContainerConfiguration(Symfony\Component\Config\Loader\LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
    }

    public function getRootDir()
    {
        return TEMP_DIR;
    }

    public function getName()
    {
        return 'integration';
    }
}
