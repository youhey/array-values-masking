<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Patterns;

class Regexp implements PatternInterface
{
    /** @var string Regexp of the key to mask */
    private $regexp;

    /**
     * constructor.
     *
     * @param string $regexp Regexp of the key to mask
     */
    public function __construct(string $regexp)
    {
        $this->regexp = $regexp;
    }

    /**
     * {@inheritdoc}
     */
    public function match(string $key): bool
    {
        return (bool)preg_match($this->regexp, $key);
    }
}
