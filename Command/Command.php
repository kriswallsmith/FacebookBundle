<?php
namespace FOS\FacebookBundle\Command;


use Symfony\Component\Console\Output\Output;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Command.
 *
 * @author Marcin Sikoń <marcin.sikon@gmail.com>
 */
abstract class Command extends BaseCommand
{

    
    /**
     * get facebook sdk
     * 
     * @codeCoverageIgnore
     * 
     * @return \Facebook
     */
    public function getFacebook() {
        return $this->container->get('fos_facebook.api');
    }
}
