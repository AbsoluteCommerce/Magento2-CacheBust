<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Console\Command;

use Symfony\Component\Console\Command\Command;
use Absolute\CacheBust\Model\CacheBust;

abstract class CommandAbstract extends Command
{
    const COMMAND_NAMESPACE = 'absolute:cache-bust:';
    
    /** @var CacheBust */
    protected $cacheBust;

    /**
     * @param CacheBust $cacheBust
     */
    public function __construct(
        CacheBust $cacheBust
    ) {
        parent::__construct();
        
        $this->cacheBust = $cacheBust;
    }
}
