<?php
namespace Absolute\CDNCacheBust\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Absolute\CDNCacheBust\Model\CacheBust;

class MediaCommand extends Command
{
    /** @var CacheBust */
    protected $cacheBustModel;

    /**
     * @param CacheBust $cacheBust
     */
    public function __construct(
        CacheBust $cacheBust
    ) {
        parent::__construct();
        
        $this->cacheBustModel = $cacheBust;
    }

    /**
     * 
     */
    protected function configure()
    {
        parent::configure();
        
        $this
            ->setName('absolute:cdncachebust:media')
            ->setDescription('Bust Media URLs.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->cacheBustModel->bustMedia();
    }
}
