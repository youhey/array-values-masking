<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Masking;

interface MaskingInterface
{
    /**
     * Mask secret string
     *
     * @param string $secret
     *
     * @return string
     */
    public function mask(string $secret): string;
}
