<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Patterns;

interface PatternInterface
{
    /**
     * Key match the masking pattern?
     *
     * @param string $key
     *
     * @return bool
     */
    public function match(string $key): bool;
}
