<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Model\Source;

class YesNo extends SourceAbstract
{
    const OPTION_YES = 1;
    const OPTION_NO  = 0;

    /** @var array */
    protected $options = [
        self::OPTION_YES => 'Yes',
        self::OPTION_NO  => 'No',
    ];
}
