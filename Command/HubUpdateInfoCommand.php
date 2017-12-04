<?php

namespace AmaxLab\Oro\Bundle\AtolHubBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class HubUpdateInfoCommand extends ContainerAwareCommand
{

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('hub:info-update')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hubManager = $this->getContainer()->get('hub_manager');
        $hubManager->loadHubsInfo();
    }
}
