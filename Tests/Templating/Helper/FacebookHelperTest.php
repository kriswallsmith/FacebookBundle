<?php

namespace Bundle\Kris\FacebookBundle\Tests\Templating\Helper;

use Bundle\Kris\FacebookBundle\Templating\Helper\FacebookHelper;

class FacebookHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialize()
    {
        $helper = new FacebookHelper('123');
        $html = $helper->initialize();
        $this->assertTrue(false !== strpos($html, '"123"'));
    }
}
