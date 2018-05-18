<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Model\Source;

use Magento\Framework\Option\ArrayInterface;

abstract class SourceAbstract implements ArrayInterface
{
    /** @var array */
    protected $options = [];

    /**
     * @param bool $withEmpty
     * @return array
     */
    public function toOptionArray($withEmpty = false)
    {
        $optionArray = [];

        foreach ($this->toArray($withEmpty) as $_value => $_label) {
            $optionArray[] = [
                'value' => $_value,
                'label' => $_label,
            ];
        }

        return $optionArray;
    }

    /**
     * @param bool $withEmpty
     * @return array
     */
    public function toArray($withEmpty = false)
    {
        $data = [];

        if ($withEmpty) {
            $data[''] = __('All');
        }

        foreach ($this->options as $_value => $_label) {
            $data[$_value] = __($_label);
        }

        return $data;
    }
}
