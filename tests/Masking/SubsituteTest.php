<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Tests\Masking;

use PHPUnit\Framework\TestCase;
use Youhey\ArrayValuesMasking\Masking\Substitute as SubstituteMasking;

class SubstituteTest extends TestCase
{
    /** @var SubstituteMasking */
    private $masking;

    protected function setUp()
    {
        $this->masking = new SubstituteMasking('*');
    }

    /**
     * @test
     */
    public function mask()
    {
        $this->assertSame('***', $this->masking->mask('foo'));
        $this->assertSame('****', $this->masking->mask('hoge'));
        $this->assertSame('**********', $this->masking->mask('I am a Cat'));
        $this->assertSame('*', $this->masking->mask('0'));
        $this->assertSame('*', $this->masking->mask('1'));
        $this->assertSame('**', $this->masking->mask('-1'));
        $this->assertSame('', $this->masking->mask(''));
    }
}
