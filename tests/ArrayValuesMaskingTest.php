<?php
/**
 * For recursively (deep) masking secret data within array-values.
 */

namespace Youhey\ArrayValuesMasking\Tests;

use PHPUnit\Framework\TestCase;
use Youhey\ArrayValuesMasking\ArrayValuesMasking;
use Youhey\ArrayValuesMasking\Patterns\PatternInterface;
use Youhey\ArrayValuesMasking\Masking\MaskingInterface;

class ArrayValuesMaskingTest extends TestCase
{
    /** @var ArrayValuesMasking */
    private $arrayValuesMasking;

    /** @var \PHPUnit_Framework_MockObject_MockObject|PatternInterface */
    private $pattern;

    /** @var \PHPUnit_Framework_MockObject_MockObject|MaskingInterface */
    private $masking;

    protected function setUp()
    {
        $this->arrayValuesMasking = new ArrayValuesMasking(
            $this->pattern = $this->createPattern(),
            $this->masking = $this->createMasking()
        );

        $this->pattern->method('match')
            ->willReturnCallback(function ($subject) {
                return ($subject === 'password');
            });

        $this->masking->method('mask')
            ->willReturnCallback(function () {
                return '***';
            });
    }

    /** @return \PHPUnit_Framework_MockObject_MockObject|PatternInterface */
    private function createPattern(): PatternInterface
    {
        return $this->createMock(PatternInterface::class);
    }

    /** @return \PHPUnit_Framework_MockObject_MockObject|MaskingInterface */
    private function createMasking(): MaskingInterface
    {
        return $this->createMock(MaskingInterface::class);
    }

    /**
     * @test
     */
    public function mask()
    {
        $this->pattern
            ->expects($this->exactly(2))
            ->method('match')
            ->withConsecutive(
                ['password'],
                ['name']
            );

        $this->masking
            ->expects($this->once())
            ->method('mask')
            ->with('123456');

        $this->arrayValuesMasking->mask([
            'password' => '123456',
            'name' => 'John Titor',
        ]);
    }

    /**
     * @test
     */
    public function numberValues()
    {
        $this->assertEquals(['password' => '***'], $this->arrayValuesMasking->mask(['password' => 123]));
        $this->assertEquals(['password' => '***'], $this->arrayValuesMasking->mask(['password' => 0xFF]));
        $this->assertEquals(['password' => '***'], $this->arrayValuesMasking->mask(['password' => 3.14]));
    }

    /**
     * @test
     */
    public function booleanValues()
    {
        $this->assertEquals(['password' => '***'], $this->arrayValuesMasking->mask(['password' => true]));
        $this->assertEquals(['password' => '***'], $this->arrayValuesMasking->mask(['password' => false]));
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     */
    public function nullIsEqualToTheEmptyString()
    {
        $this->assertEquals(['password' => '***'], $this->arrayValuesMasking->mask(['password' => null]));
    }

    /**
     * @test
     */
    public function objectNotSupported()
    {
        $password = new \stdClass();
        $password->value = '123456';

        $data = [
            'password' => $password,
            'name' => 'John Titor',
        ];

        $result = $this->arrayValuesMasking->mask($data);

        $this->assertSame('123456', $result['password']->value);
        $this->assertSame($password, $result['password']);
    }

    /**
     * @test
     */
    public function recursively()
    {
        $this->assertEquals(
            [
                'users' => [
                    'properties' => [
                        'password' => '***',
                        'name' => 'John Titor',
                    ]
                ],
            ],
            $this->arrayValuesMasking->mask([
                'users' => [
                    'properties' => [
                        'password' => '123456',
                        'name' => 'John Titor',
                    ]
                ],
            ])
        );
    }

    /**
     * @test
     */
    public function deep()
    {
        $this->assertEquals(
            [
                'password' => [
                    'num' => '***',
                    'char' => '***',
                    'array' => ['***', '***', '***'],
                ],
                'name' => 'John Titor',
            ],
            $this->arrayValuesMasking->mask([
                'password' => [
                    'num' => '123456',
                    'char' => 'abcdef',
                    'array' => [1, 2, 3],
                ],
                'name' => 'John Titor',
            ])
        );
    }

    /**
     * @test
     */
    public function notReference()
    {
        $data = [
            'password' => '123456',
            'name' => 'John Titor',
        ];
        $this->arrayValuesMasking->mask($data);

        $this->assertEquals(
            [
                'password' => '123456',
                'name' => 'John Titor',
            ],
            $data
        );
    }
}
