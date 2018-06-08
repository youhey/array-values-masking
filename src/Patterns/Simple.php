<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Patterns;

class Simple implements PatternInterface
{
    /** @var string Name of the key to mask */
    private $key;

    /**
     * constructor.
     *
     * @param string $key Name of the key to mask
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function match(string $key): bool
    {
        return ($key === $this->key);
    }
}
