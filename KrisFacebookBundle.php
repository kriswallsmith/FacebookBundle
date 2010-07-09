<?php

namespace Bundle\Kris\FacebookBundle;

use Symfony\Framework\Bundle\Bundle;
use Symfony\Components\DependencyInjection\ContainerInterface;
use Symfony\Components\DependencyInjection\Loader\Loader;
use Bundle\Kris\FacebookBundle\DependencyInjection\FacebookExtension;

class KrisFacebookBundle extends Bundle
{
    public function buildContainer(ContainerInterface $container)
    {
        Loader::registerExtension(new FacebookExtension());
    }
}
