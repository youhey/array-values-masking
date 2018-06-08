<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking;

class ArrayValuesMasking
{
    /** @var Patterns\PatternInterface */
    private $pattern;

    /** @var Masking\MaskingInterface */
    private $masking;

    /**
     * constructor.
     *
     * @param Patterns\PatternInterface $pattern
     * @param Masking\MaskingInterface $masking
     */
    public function __construct(Patterns\PatternInterface $pattern, Masking\MaskingInterface $masking)
    {
        $this->pattern = $pattern;
        $this->masking = $masking;
    }

    /**
     * Search keys matching the pattern from the array and mask the value if matched.
     *
     * @param array $data
     *
     * @return array
     */
    public function mask(array $data): array
    {
        $this->recursiveHideValues($data);
        return $data;
    }

    /**
     * Shortcut to mask with key
     *
     * @param string $key
     * @param array $data
     * @param string $maskChar
     *
     * @return array
     */
    public static function keyIs(string $key, array $data, string $maskChar = '*'): array
    {
        return (new static(new Patterns\Simple($key), new Masking\Substitute($maskChar)))->mask($data);
    }

    /**
     * Shortcut to mask with regexp
     *
     * @param string $regexp
     * @param array $data
     * @param string $maskChar
     *
     * @return array
     */
    public static function regexp(string $regexp, array $data, string $maskChar = '*'): array
    {
        return (new static(new Patterns\Regexp($regexp), new Masking\Substitute($maskChar)))->mask($data);
    }

    /**
     * recursively callback
     *
     * @param mixed $data
     * @param bool $inPassword
     *
     * @return void
     */
    private function recursiveHideValues(&$data, bool $inPassword = false)
    {
        if ($inPassword && is_string($data)) {
            $data = $this->masking->mask($data);
            return;
        }
        if ($inPassword && is_numeric($data)) {
            $data = $this->masking->mask((string)$data);
            return;
        }
        if ($inPassword && is_bool($data)) {
            $data = $this->masking->mask($data ? '1' : '0');
            return;
        }
        if ($inPassword && is_null($data)) {
            $data = $this->masking->mask('');
            return;
        }

        if (is_array($data)) {
            $originalFlag = $inPassword;
            foreach ($data as $key => &$value) {
                if ($this->pattern->match($key)) {
                    $inPassword = true;
                }
                $this->recursiveHideValues($value, $inPassword);
                unset($value);
                $inPassword = $originalFlag;
            }
        }
    }
}
