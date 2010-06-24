<?php

namespace Bundle\FacebookBundle;

use Symfony\Foundation\Bundle\Bundle;
use Symfony\Components\DependencyInjection\ContainerInterface;
use Symfony\Components\DependencyInjection\Loader\Loader;
use Bundle\FacebookBundle\DependencyInjection\FacebookExtension;

class FacebookBundle extends Bundle
{
    public function buildContainer(ContainerInterface $container)
    {
        Loader::registerExtension(new FacebookExtension());
    }
}
