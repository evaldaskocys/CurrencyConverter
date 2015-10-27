<?php

namespace AppBundle\Tests\Command;

use AppBundle\Command\UpdateRatesCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class UpdateRatesCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $mockManager = $this
            ->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $mockManager->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));
        $mockManager->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(null));

        $kernel->getContainer()->set('doctrine.orm.default_entity_manager', $mockManager);

        $application = new Application($kernel);
        $application->add(new UpdateRatesCommand());

        $command = $application->find('currency:rates:update');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertRegExp('/Updated currency rates for (.*)./', $commandTester->getDisplay());
    }
}
