<?php

namespace Bundle\Kris\FacebookBundle;

use Symfony\Framework\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bundle\Kris\FacebookBundle\DependencyInjection\FacebookExtension;

class KrisFacebookBundle extends Bundle
{
    public function buildContainer(ParameterBagInterface $parameterBag)
    {
        ContainerBuilder::registerExtension(new FacebookExtension());
    }
}
