<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Tests\Patterns;

use PHPUnit\Framework\TestCase;
use Youhey\ArrayValuesMasking\Patterns\Simple as SimpleKeyPattern;

class SimpleTest extends TestCase
{
    /** @var SimpleKeyPattern */
    private $pattern;

    protected function setUp()
    {
        $this->pattern = new SimpleKeyPattern('foo');
    }

    /**
     * @test
     */
    public function match()
    {
        $this->assertTrue($this->pattern->match('foo'));
        $this->assertFalse($this->pattern->match('bar'));
    }
}
