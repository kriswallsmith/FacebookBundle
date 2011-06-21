<?php

/*
 * This file is part of the FOSFacebookBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\FacebookBundle\Tests\Command;

use FOS\FacebookBundle\Command\TestUsersDeleteCommand;
use FOS\FacebookBundle\Tests\Kernel;
use FOS\FacebookBundle\DependencyInjection\FacebookExtension;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;

/**
 *
 * @author Marcin Sikoń <marcin.sikon@gmail.com>
 *
 */
class TestUsersDeleteCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provider
     */
    public function simpleRequest($userId, $appId, $accessToken, $json, $params, $resultApi, $result)
    {
        $facebook = $this->getMock('Facebook', array('api','getAppId'));
        $facebook
            ->expects($this->once())
            ->method('api')
            ->with($this->equalTo($userId), $this->equalTo('DELETE'), $this->equalTo($params))
            ->will($this->returnValue($resultApi));

        $facebook
            ->expects($this->once())
            ->method('getAppId')
            ->will($this->returnValue($appId));

        $applicationAccessTokenCommand = $this->getMock('FOS\\FacebookBundle\\Command\\ApplicationAccessTokenCommand', array('getAccessToken'));

        $applicationAccessTokenCommand
            ->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($accessToken));

        $application = new Application(new Kernel());
        $application->getKernel()->getContainer()->set('fos_facebook.api', $facebook);

        $command = new TestUsersDeleteCommand();
        $command->setApplicationAccessTokenCommand($applicationAccessTokenCommand);
        $command->setApplication($application);

        $commandTester = new CommandTester($command);

        $commandTester->execute(array('command' => 'facebook:test-users:delete', 'test_user_id' => $userId, '--json' => $json));

        $this->assertRegExp('/'.$result.'/', $commandTester->getDisplay());
    }

    /**
     * @test
     * @expectedException \FacebookApiException
     */
    public function emptyAppIdConfig()
    {
        $facebook = $this->getMock('Facebook', array('getAppId'));

        $facebook
            ->expects($this->once())
            ->method('getAppId')
            ->will($this->returnValue(null));

        $applicationAccessTokenCommand = $this->getMock('FOS\\FacebookBundle\\Command\\ApplicationAccessTokenCommand', array('getAccessToken'));

        $application = new Application(new Kernel());
        $application->getKernel()->getContainer()->set('fos_facebook.api', $facebook);

        $command = new TestUsersDeleteCommand();
        $command->setApplicationAccessTokenCommand($applicationAccessTokenCommand);
        $command->setApplication($application);

        $commandTester = new CommandTester($command);

        $commandTester->execute(array('command' => 'facebook:test-users:delete', 'test_user_id' => 123));
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function requiredArgument()
    {
        $facebook = $this->getMock('Facebook', array('getAppId'));

        $applicationAccessTokenCommand = $this->getMock('FOS\\FacebookBundle\\Command\\ApplicationAccessTokenCommand', array('getAccessToken'));

        $application = new Application(new Kernel());
        $application->getKernel()->getContainer()->set('fos_facebook.api', $facebook);

        $command = new TestUsersDeleteCommand();
        $command->setApplicationAccessTokenCommand($applicationAccessTokenCommand);
        $command->setApplication($application);

        $commandTester = new CommandTester($command);

        $commandTester->execute(array('command' => 'facebook:test-users:delete'));
    }

    public function provider()
    {
        return array(
        array(1, 12345678, 'accesstoken', true, array('access_token' => 'accesstoken'), true, 'true'),
        array(2, 12345678,'accesstoken',true, array('access_token' => 'accesstoken'), false, 'false'),
        array(3, 12345678,'accesstoken', false, array('access_token' => 'accesstoken'), true, 'was'),
        array(6, 12345678,'accesstoken',false, array('access_token' => 'accesstoken'), false, 'wasn'),
        );
    }
}
