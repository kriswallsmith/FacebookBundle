<?php

namespace FOS\FacebookBundle\Tests\DependencyInjection;

use FOS\FacebookBundle\DependencyInjection\FacebookExtension;

class FacebookExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers FOS\FacebookBundle\DependencyInjection\FacebookExtension::apiLoad
     */
    public function testApiLoadLoadsDefaults()
    {
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $extension = $this->getMockBuilder('FOS\\FacebookBundle\\DependencyInjection\\FacebookExtension')
            ->setMethods(array('loadDefaults'))
            ->getMock();
        $extension
            ->expects($this->once())
            ->method('loadDefaults')
            ->with($container);

        $extension->apiLoad(array(array()), $container);
    }

    /**
     * @covers FOS\FacebookBundle\DependencyInjection\FacebookExtension::apiLoad
     */
    public function testApiLoadSetsAlias()
    {
        $alias = 'foo';

        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $container
            ->expects($this->once())
            ->method('setAlias')
            ->with($alias, 'fos_facebook.api');

        $parameterBag = $this->getMockBuilder('Symfony\Component\DependencyInjection\ParameterBag\\ParameterBag')
            ->disableOriginalConstructor()
            ->getMock();

        $parameterBag
            ->expects($this->any())
            ->method('add');

        $container
            ->expects($this->any())
            ->method('getParameterBag')
            ->will($this->returnValue($parameterBag));

        $extension = new FacebookExtension();
        $extension->apiLoad(array(array('alias' => $alias)), $container);
    }

    /**
     * @covers FOS\FacebookBundle\DependencyInjection\FacebookExtension::apiLoad
     * @dataProvider parameterNames
     */
    public function testApiLoadSetParameters($name, $value)
    {
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $container
            ->expects($this->once())
            ->method('setParameter')
            ->with('fos_facebook.'.$name, $value);

        $parameterBag = $this->getMockBuilder('Symfony\Component\DependencyInjection\ParameterBag\\ParameterBag')
            ->disableOriginalConstructor()
            ->getMock();

        $parameterBag
            ->expects($this->any())
            ->method('add');

        $container
            ->expects($this->any())
            ->method('getParameterBag')
            ->will($this->returnValue($parameterBag));

        $extension = new FacebookExtension();
        $extension->apiLoad(array(array($name => $value)), $container);
    }

    public function parameterNames()
    {
        return array(
            array('class', 'foo'),
            array('app_id', 'foo'),
            array('secret', 'foo'),
            array('cookie', 'foo'),
            array('domain', 'foo'),
            array('logging', 'foo'),
            array('culture', 'foo'),
            array('permissions', array('email')),
        );
    }
}
