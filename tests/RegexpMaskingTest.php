<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Tests;

use PHPUnit\Framework\TestCase;
use Youhey\ArrayValuesMasking\ArrayValuesMasking;
use Youhey\ArrayValuesMasking\Patterns\Regexp as RegexpPattern;
use Youhey\ArrayValuesMasking\Masking\FixedChar as FixedMasking;

class RegexpMaskingTest extends TestCase
{
    /** @var ArrayValuesMasking */
    private $arrayValuesMasking;

    protected function setUp()
    {
        $this->arrayValuesMasking = new ArrayValuesMasking(
            new RegexpPattern('/^(?:[a-zA-Z0-9]*[-_])*password(?:[-_][a-zA-Z0-9]*)*$/'),
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
                'old_password' => '***',
                'new_password' => '***',
                'name' => 'John Titor',
                'password_confirmed' => '***',
            ],
            $this->arrayValuesMasking->mask([
                'old_password' => 'foo bar',
                'new_password' => '123456',
                'name' => 'John Titor',
                'password_confirmed' => '123456',
            ])
        );
    }
}
