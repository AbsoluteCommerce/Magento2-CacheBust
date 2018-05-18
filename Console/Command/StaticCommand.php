<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StaticCommand extends CommandAbstract
{
    /**
     *
     */
    protected function configure()
    {
        parent::configure();
        
        $this
            ->setName(self::COMMAND_NAMESPACE . 'static')
            ->setDescription('Bust Static URLs.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->cacheBust->bustStatic();
        $output->writeln('<info>Static URLs cache busted successfully.</info>');
    }
}
