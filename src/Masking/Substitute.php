<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Masking;

class Substitute implements MaskingInterface
{
    /** @var string char to mask */
    private $mask;

    /**
     * constructor.
     *
     * @param string $mask Char to mask
     */
    public function __construct(string $mask)
    {
        $this->mask = $mask;
    }

    /**
     * {@inheritdoc}
     */
    public function mask(string $secret): string
    {
        return str_repeat($this->mask, strlen($secret));
    }
}
