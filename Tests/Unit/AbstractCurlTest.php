<?php

/*
 * This file is part of the AnchovyCURLBundle package.
 *
 * (c)  Iman Samizadeh <http://github.com/Iman/AnchovyCURLBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package       Anchovy
 * @subpackage    CURLBundle
 * @author        Iman Samizadeh <iman@imanpage.com>  http://imanpage.com
 */

namespace Anchovy\CURLBundle\Test\Unit;

use Anchovy\CURLBundle\CURL\AbstractCurl;

class AbstractCurlTest extends \PHPUnit_Framework_TestCase {

    private $simpleHtmplFixture;
    private $dummyURL = 'http://dummy_url.com';
    private $mockInfo = array('foo' => 'bar');

    protected function setUp() {

        $this->simpleHtmplFixture = file_get_contents(__DIR__ . '/../Fixtures/simpleHtml.html');
    }

    public function testAbstractExecute() {
        $stub = $this->getMockForAbstractClass('Anchovy\CURLBundle\CURL\AbstractCurl');
        $stub->expects($this->any())
                ->method('execute')
                ->will($this->returnValue($this->simpleHtmplFixture));

        $this->assertEquals($stub->execute(), $this->simpleHtmplFixture);
    }

    public function testAbstractSetURL() {
        $stub = $this->getMockForAbstractClass('Anchovy\CURLBundle\CURL\AbstractCurl');
        $stub->expects($this->once())
                ->method('setURL')
                ->will($this->returnArgument(0));

        $this->assertEquals($stub->setURL($this->dummyURL), $this->dummyURL);
    }

    public function testAbstractGetInfo() {
        $stub = $this->getMockForAbstractClass('Anchovy\CURLBundle\CURL\AbstractCurl');
        $stub->expects($this->any())
                ->method('getInfo')
                ->will($this->returnValue($this->mockInfo));

        $this->assertInternalType('array', $stub->getInfo());
    }

    public function testAbstractSetOption() {
        $stub = $this->getMockForAbstractClass('Anchovy\CURLBundle\CURL\AbstractCurl');
        $stub->expects($this->any())
                ->method('setOption')
                ->will($this->returnValue(True));


        $this->assertEquals('VALUE', $stub->setOption('CURL_OPTION_HERE', 'VALUE'));
    }

    public function testAbstractSetOptions() {
        $stub = $this->getMockForAbstractClass('Anchovy\CURLBundle\CURL\AbstractCurl');
        $stub->expects($this->any())
                ->method('setOptions')
                ->will($this->returnValue(array()));

        $this->assertInternalType('array', $stub->setOptions(array('apple' => 'red', 'tree' => 'leaf')));
    }

    public function testAbstractSetMethod() {

        $stubA = $this->getMockForAbstractClass('Anchovy\CURLBundle\CURL\AbstractCurl');
        $stubA->expects($this->any())
                ->method('setMethod')
                ->will($this->returnArgument(0));

        $this->assertInternalType('object', $stubA->setMethod('POST, PUT or DELETE', array('HTTP/URL Query')));
    }

}

?>
