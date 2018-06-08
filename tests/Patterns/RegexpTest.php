<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Tests\Patterns;

use PHPUnit\Framework\TestCase;
use Youhey\ArrayValuesMasking\Patterns\Regexp as RegexpKeyPattern;

class RegexpTest extends TestCase
{
    /** @var RegexpKeyPattern */
    private $pattern;

    protected function setUp()
    {
        $this->pattern = new RegexpKeyPattern('/^(foo\d*|hoge)$/');
    }

    /**
     * @test
     */
    public function match()
    {
        $this->assertTrue($this->pattern->match('foo'));
        $this->assertTrue($this->pattern->match('foo123'));
        $this->assertTrue($this->pattern->match('hoge'));
        $this->assertFalse($this->pattern->match('bar'));
        $this->assertFalse($this->pattern->match('hoge123'));
    }
}
