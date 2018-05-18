<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MediaCommand extends CommandAbstract
{
    /**
     *
     */
    protected function configure()
    {
        parent::configure();
        
        $this
            ->setName(self::COMMAND_NAMESPACE . 'media')
            ->setDescription('Bust Media URLs.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->cacheBust->bustMedia();
        $output->writeln('<info>Media URLs cache busted successfully.</info>');
    }
}
