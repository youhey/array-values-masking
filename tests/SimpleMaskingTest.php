<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Tests;

use PHPUnit\Framework\TestCase;
use Youhey\ArrayValuesMasking\ArrayValuesMasking;
use Youhey\ArrayValuesMasking\Patterns\Simple as SimpleKeyPattern;
use Youhey\ArrayValuesMasking\Masking\FixedChar as FixedMasking;

class SimpleMaskingTest extends TestCase
{
    /** @var ArrayValuesMasking */
    private $arrayValuesMasking;

    protected function setUp()
    {
        $this->arrayValuesMasking = new ArrayValuesMasking(
            new SimpleKeyPattern('password'),
            new FixedMasking('***')
        );
    }

    /**
     * @test
     */
    public function mask()
    {
        $this->assertEquals(
            [
                'password' => '***',
                'name' => 'John Titor',
            ],
            $this->arrayValuesMasking->mask([
                'password' => '123456',
                'name' => 'John Titor',
            ])
        );
    }
}
