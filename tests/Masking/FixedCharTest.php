<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Tests\Masking;

use PHPUnit\Framework\TestCase;
use Youhey\ArrayValuesMasking\Masking\FixedChar as FixedCharMasking;

class FixedCharTest extends TestCase
{
    /** @var FixedCharMasking */
    private $masking;

    protected function setUp()
    {
        $this->masking = new FixedCharMasking('***');
    }

    /**
     * @test
     */
    public function mask()
    {
        $this->assertSame('***', $this->masking->mask('I am a Cat'));
        $this->assertSame('***', $this->masking->mask('0'));
        $this->assertSame('***', $this->masking->mask('1'));
        $this->assertSame('***', $this->masking->mask('-1'));
        $this->assertSame('***', $this->masking->mask(''));
    }
}
