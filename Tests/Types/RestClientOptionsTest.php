<?php
/**
 * This file is part of DoctrineRestDriverBundle.
 *
 * DoctrineRestDriverBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DoctrineRestDriverBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DoctrineRestDriverBundle.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Circle\DoctrineRestDriverBundle\Tests\Types;

use Circle\DoctrineRestDriverBundle\Types\RestClientOptions;

/**
 * Tests the rest client options
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Circle\DoctrineRestDriverBundle\Types\RestClientOptions
 */
class RestClientOptionsTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $expected;

    /**
     * {@inheritdoc}
     */
    public function setUp() {
        $this->options = [
            'driver_class'  => 'Circle\DoctrineRestDriverBundle\Driver',
            'host'          => 'http://www.circle.ai',
            'port'          => '8080',
            'dbname'        => 'circle',
            'user'          => 'circleUser',
            'password'      => 'mySecretPassword',
            'charset'       => 'UTF8',
            'driverOptions' => [
                'security_strategy'  => 'none',
                'CURLOPT_MAXREDIRS'  => 22,
                'CURLOPT_HTTPHEADER' => 'Content-Type: text/plain'
            ]
        ];

        $this->expected = [
            CURLOPT_HTTPHEADER     => ['Content-Type: text/plain'],
            CURLOPT_MAXREDIRS      => 22,
            CURLOPT_TIMEOUT        => 25,
            CURLOPT_CONNECTTIMEOUT => 25,
            CURLOPT_CRLF           => true,
            CURLOPT_SSLVERSION     => 3,
            CURLOPT_FOLLOWLOCATION => true,
        ];
    }

    /**
     * @test
     * @group  unit
     * @covers ::__construct
     * @covers ::all
     * @covers ::<private>
     * @covers \Circle\DoctrineRestDriverBundle\Types\RestClientSecurityOptions::__construct
     * @covers \Circle\DoctrineRestDriverBundle\Types\RestClientSecurityOptions::all
     * @covers \Circle\DoctrineRestDriverBundle\Types\RestClientSecurityOptions::<private>
     */
    public function all() {
        $options  = new RestClientOptions($this->options);
        $expected = $this->expected;

        $this->assertEquals($expected, $options->all());
    }

    /**
     * @test
     * @group unit
     * @covers ::__construct
     * @covers ::all
     * @covers ::<private>
     * @covers \Circle\DoctrineRestDriverBundle\Types\RestClientSecurityOptions::__construct
     * @covers \Circle\DoctrineRestDriverBundle\Types\RestClientSecurityOptions::all
     * @covers \Circle\DoctrineRestDriverBundle\Types\RestClientSecurityOptions::<private>
     */
    public function allWithBasicHttpAuth() {
        $options                                       = $this->options;
        $options['driverOptions']['security_strategy'] = 'basic_http';
        $options                                       = new RestClientOptions($options);
        $expected                                      = $this->expected;

        $expected[CURLOPT_HTTPHEADER] = [
            'Content-Type: text/plain',
            'Authorization: Basic Y2lyY2xlVXNlcjpteVNlY3JldFBhc3N3b3Jk'
        ];

        $this->assertEquals($expected, $options->all());
    }
}