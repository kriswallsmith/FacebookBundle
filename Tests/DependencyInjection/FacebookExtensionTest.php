<?php

namespace Bundle\Kris\FacebookBundle\Tests\DependencyInjection;

use Bundle\Kris\FacebookBundle\DependencyInjection\FacebookExtension;

class FacebookExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testApiLoadLoadsDefaults()
    {
        $container = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with('kris.facebook')
            ->will($this->returnValue(false));

        $extension = $this->getMockBuilder('Bundle\\Kris\\FacebookBundle\\DependencyInjection\\FacebookExtension')
            ->setMethods(array('loadDefaults'))
            ->getMock();
        $extension
            ->expects($this->once())
            ->method('loadDefaults')
            ->with($container);

        $extension->apiLoad(array(), $container);
    }

    public function testApiLoadDoesNotReloadDefaults()
    {
        $container = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with('kris.facebook')
            ->will($this->returnValue(true));

        $extension = $this->getMockBuilder('Bundle\\Kris\\FacebookBundle\\DependencyInjection\\FacebookExtension')
            ->setMethods(array('loadDefaults'))
            ->getMock();
        $extension
            ->expects($this->never())
            ->method('loadDefaults');

        $extension->apiLoad(array(), $container);
    }

    public function testApiLoadSetsAlias()
    {
        $alias = 'foo';

        $container = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with('kris.facebook')
            ->will($this->returnValue(true));
        $container
            ->expects($this->once())
            ->method('setAlias')
            ->with($alias, 'kris.facebook');

        $extension = new FacebookExtension();
        $extension->apiLoad(array('alias' => $alias), $container);
    }

    /**
     * @dataProvider parameterNames
     */
    public function testApiLoadSetParameters($name)
    {
        $value = 'foo';

        $container = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder');
        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with('kris.facebook')
            ->will($this->returnValue(true));
        $container
            ->expects($this->once())
            ->method('setParameter')
            ->with('kris.facebook.'.$name, $value);

        $extension = new FacebookExtension();
        $extension->apiLoad(array($name => $value), $container);
    }

    public function parameterNames()
    {
        return array(
            array('class'),
            array('app_id'),
            array('secret'),
            array('cookie'),
            array('domain'),
            array('logging'),
            array('culture'),
        );
    }
}
