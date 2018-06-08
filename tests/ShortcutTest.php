<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Tests;

use PHPUnit\Framework\TestCase;
use Youhey\ArrayValuesMasking\ArrayValuesMasking;

class ShortcutTest extends TestCase
{
    /**
     * @test
     */
    public function keyIs()
    {
        $this->assertEquals(
            [
                'password' => '******',
                'name' => 'John Titor',
            ],
            ArrayValuesMasking::keyIs('password', [
                'password' => '123456',
                'name' => 'John Titor',
            ])
        );
    }

    /**
     * @test
     */
    public function regexp()
    {
        $this->assertEquals(
            [
                'old_password' => '*******',
                'new_password' => '******',
                'name' => 'John Titor',
                'password_confirmed' => '******',
            ],
            ArrayValuesMasking::regexp('/^(?:[a-zA-Z0-9]*[-_])*password(?:[-_][a-zA-Z0-9]*)*$/', [
                'old_password' => 'foo bar',
                'new_password' => '123456',
                'name' => 'John Titor',
                'password_confirmed' => '123456',
            ])
        );
    }
}
