<?php

namespace Optional;

use PHPUnit\Framework\TestCase;

class OptionalTest extends TestCase
{
    protected $optional;

    /**
     * @test
     */
    public function testEmpty()
    {
        $actual = Optional::empty()->isPresent();
        $expected = false;

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @dataProvider testEqualsDataProvider
     */
    public function testEquals($value, $object, $expected)
    {
        $this->assertEquals($expected, Optional::of($value)->equals($object));
    }

    public function testEqualsDataProvider()
    {
        return [
            [
                true,
                Optional::of(true),
                true
            ],
            [
                true,
                Optional::of(false),
                false
            ],
            [
                true,
                new \StdClass,
                false
            ]
        ];
    }

    /**
     * @test
     * @expectedException Optional\NullPointerException
     */
    public function testFilter_throwsException()
    {
        $this->expectException(NullPointerException::class);

        Optional::of(true)->filter(null);
    }

    /**
     * @test
     * @dataProvider testFilterDataProvider
     */
    public function testFilter($res, $expected)
    {
        $optional = Optional::of(1);
        $actual = $optional->filter(function ($v) use ($res) {
            return $res;
        })->isPresent();

        $this->assertEquals($expected, $actual);
    }

    public function testFilterDataProvider()
    {
        return [
            [
                true,
                true
            ],
            [
                false,
                false
            ]
        ];
    }

    /**
     * @test
     * @dataProvider testFlatMapDataProvider
     */
    public function testFlatMap($value, $expected)
    {
        $optional = Optional::of($value);
        $actual = $optional->flatMap(function ($v) {
            return $v * 2;
        });

        $this->assertEquals($expected, $actual);
    }

    public function testFlatMapDataProvider()
    {
        return [
            [
                2,
                4
            ]
        ];
    }

    /**
     * @test
     */
    public function testGet_throwsException()
    {
        $this->expectException(NullPointerException::class);

        Optional::of(null)->get();
    }

    /**
     * @test
     */
    public function testGet()
    {
        $actual = Optional::of(true)->get();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function testHashCode()
    {
        $optional = Optional::of(true);

        $actual = $optional->hashCode();
        $expected = spl_object_hash($optional);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testIfPresent()
    {
        $actual = Optional::of(1)->ifPresent(function ($v) {
            return $v * 100;
        });
        $expected = 100;

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @dataProvider testIsPresentDataProvider
     */
    public function testIsPresent($value, $expected)
    {
        $actual = Optional::ofNullable($value)->isPresent();

        $this->assertEquals($expected, $actual);
    }

    public function testIsPresentDataProvider()
    {
        return [
            [
                true,
                true
            ],
            [
                null,
                false
            ]
        ];
    }

    /**
     * @test
     */
    public function testOf_throwsException()
    {
        $this->expectException(NullPointerException::class);

        Optional::of(null);
    }

    /**
     * @test
     */
    public function testOf()
    {
        $actual = Optional::of(true)->get();

        $this->assertTrue($actual);
    }

    /**
     * @test
     * @dataProvider testOfNullableDataProvider
     */
    public function testOfNullable($value)
    {
        Optional::ofNullable($value);

        $this->assertTrue(true);
    }

    public function testOfNullableDataProvider()
    {
        return [
            [
                true
            ],
            [
                null
            ]
        ];
    }

    /**
     * @test
     * @dataProvider testOrElseDataProvider
     */
    public function testOrElse($value, $expected)
    {
        $actual = Optional::ofNullable($value)->orElse('B');

        $this->assertEquals($expected, $actual);
    }

    public function testOrElseDataProvider()
    {
        return [
            [
                'A',
                'A'
            ],
            [
                null,
                'B'
            ]
        ];
    }

    /**
     * @test
     * @dataProvider testOrElseGetDataProvider
     */
    public function testOrElseGet($value, $other, $expected)
    {
        $actual = Optional::ofNullable($value)->orElseGet($other);

        $this->assertEquals($expected, $actual);
    }

    public function testOrElseGetDataProvider()
    {
        return [
            [
                true,
                function ($v) {},
                true
            ],
            [
                null,
                function () { return false; },
                false
            ]
        ];
    }

    public function testToString()
    {
        $actual = Optional::of('test')->toString();
        $expected = 'Optional[test]';

        $this->assertEquals($expected, $actual);
    }
}
