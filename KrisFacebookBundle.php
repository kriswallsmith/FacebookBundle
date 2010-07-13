<?php

namespace Bundle\Kris\FacebookBundle;

use Symfony\Framework\Bundle\Bundle;
use Symfony\Components\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Components\DependencyInjection\Loader\Loader;
use Bundle\Kris\FacebookBundle\DependencyInjection\FacebookExtension;

class KrisFacebookBundle extends Bundle
{
    public function buildContainer(ParameterBagInterface $parameterBag)
    {
        Loader::registerExtension(new FacebookExtension());
    }
}
