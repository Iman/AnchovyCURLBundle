<?php

/*
 * This file is part of the CURLBundle package.
 *
 * (c)  Iman Samizadeh <https://github.com/Iman/CURLBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package       CURLBundle
 * @author        Iman Samizadeh <iman@imanpage.com>  http://imanpage.com
 */

namespace Anchovy\CURLBundle\Test\Unit;

use Anchovy\CURLBundle\CURL\Curl;

class CurlTest extends \PHPUnit_Framework_TestCase
{

    private $curl;
    private $mockUrl = 'http://foo.com';
    private $mockInfo = array(
        'url' => 'http://boo.net/',
        'content_type' => 'text/html',
        'http_code' => 200,
        'header_size' => 284,
        'request_size' => 48,
        'filetime' => '-1',
        'ssl_verify_result' => 0,
        'redirect_count' => 0,
        'total_time' => 0.920836,
        'namelookup_time' => 0.093214,
        'connect_time' => 0.093576,
        'pretransfer_time' => 0.093599,
        'size_upload' => 0,
        'size_download' => 177,
        'speed_download' => 192,
        'speed_upload' => 0,
        'download_content_length' => 177,
        'upload_content_length' => 0,
        'starttransfer_time' => 0.863111,
        'redirect_time' => 0,
        'certinfo' => array(),
    );

    private $dummyConfigs = array(
        'return_transfer' => true,
        'follow_location' => true,
        'max_redirects' => 5,
        'timeout' => 25,
        'connect_timeout' => 25,
        'http_header' => array(
            'expect' => ""),
        'crlf' => true,
        'ssl_version' => 3,
        'ssl_verify' => 0);

    private $simpleHtmplFixture;

    protected function setUp()
    {

        $this->simpleHtmplFixture = file_get_contents(__DIR__ . '/../Fixtures/simpleHtml.html');
        $this->curl = new Curl($this->dummyConfigs);
    }

    public function testSetURL()
    {

        $this->curl->setUrl($this->mockUrl);

        $prob = new \ReflectionProperty($this->curl, 'url');
        $prob->setAccessible(true);
        $content = $prob->getValue($this->curl);

        $this->assertEquals($content, $this->mockUrl);
    }

    public function testGetUrl()
    {

        $prob = new \ReflectionProperty($this->curl, 'url');
        $prob->setAccessible(true);
        $prob->setValue($this->curl, $this->mockUrl);

        $method = new \ReflectionMethod($this->curl, 'getURL');
        $method->setAccessible(true);
        $content = $method->invoke($this->curl);

        $this->assertEquals($content, $this->mockUrl);
    }

    public function testExecute()
    {

        $stub = $this->getMock('Anchovy\CURLBundle\CURL\Curl', array('execute'), array(), '', FALSE, FALSE);
        $stub->expects($this->any())
            ->method('execute')
            ->will($this->returnValue($this->simpleHtmplFixture));

        $this->assertEquals($this->simpleHtmplFixture, $stub->execute());
    }

    public function testGetInfoWithExecute()
    {


        $stub = $this->getMock('Anchovy\CURLBundle\CURL\Curl', array('execute', 'getInfo'), array(), '', FALSE, FALSE);

        //To stub channing method
        $stub->expects($this->any())->method('getInfo')
            ->will($this->returnValue($this->mockInfo));

        $stub->expects($this->any())->method($this->anything())
            ->will($this->returnValue($stub));

        $this->assertEquals($this->mockInfo, $stub->getInfo());
    }

    public function testExecuteAsObject()
    {


        $stub = $this->getMock('Anchovy\CURLBundle\CURL\Curl', array('execute'), array(), '', FALSE, FALSE);

        $stub->expects($this->any())->method($this->anything())
            ->will($this->returnValue($stub));

        $this->assertInternalType('object', $stub->execute());
    }

    public function testSetMethod()
    {

        $stub = $this->getMock('Anchovy\CURLBundle\CURL\Curl', array('setMethod'), array(), '', FALSE, FALSE);

        foreach (array('POST', 'PUT', 'DELETE') as $key => $val) {
            $stub->expects($this->any())
                ->method('setMethod')
                ->will($this->returnValue($this->curl->setmethod($key, array('Filed' => 'Value'))));

            $this->assertInternalType('object', $stub->setMethod($val, array('Filed' => 'Value')));
        }
    }

    public function testGetInfo()
    {

        $stub = $this->getMock('Anchovy\CURLBundle\CURL\Curl', array('getInfo'), array(), '', FALSE, FALSE);
        $stub->expects($this->once())
            ->method('getInfo')
            ->will($this->returnValue($this->mockInfo));

        $this->assertEquals($this->mockInfo, $stub->getInfo());
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Error: <url> malformed and the Error no is: 3
     */
    public function testGetError()
    {

        $curl = new Curl($this->dummyConfigs);
        $curl->setURL(null)->execute();
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Error: <url> malformed and the Error no is: 3
     */
    public function testChainedGetInfoWithError()
    {

        $curl = new Curl($this->dummyConfigs);
        $curl->setURL(null)->getInfo();
    }

    public function testGetErrorReturnFalse()
    {

        $method = new \ReflectionMethod($this->curl, 'getError');
        $method->setAccessible(true);
        $content = $method->invoke($this->curl);

        $this->assertFalse($content);
    }

    public function testSetOption()
    {

        $this->curl->setOption('CURLOPT_VERBOSE', True);

        $method = new \ReflectionMethod($this->curl, 'getOptions');
        $method->setAccessible(true);
        $content = $method->invoke($this->curl);

        $this->assertContains(CURLOPT_VERBOSE, $content);
    }

    public function testSetOptions()
    {

        $options = array(
            'CURLOPT_VERBOSE' => True,
            'CURLOPT_NOBODY' => True,
            'CURLOPT_BINARYTRANSFER' => false
        );

        $this->curl->setOptions($options);

        $method = new \ReflectionMethod($this->curl, 'getOptions');
        $method->setAccessible(true);

        $content = $method->invoke($this->curl);

        $this->assertContains(array(CURLOPT_VERBOSE, CURLOPT_NOBODY, CURLOPT_BINARYTRANSFER), $content);
    }

    public function testOverrideOptions()
    {

        $options = array(
            'CURLOPT_RETURNTRANSFER' => True,
            'CURLOPT_HTTPHEADER' => array("Expect:Dummy")
        );

        $this->curl->setOptions($options);

        $method = new \ReflectionMethod($this->curl, 'getOptions');
        $method->setAccessible(true);

        $content = $method->invoke($this->curl);

        $_curl = new Curl($this->dummyConfigs);
        $_curl->setURL('http://dummy.org');

        $actual = $method->invoke($_curl);

        $this->assertEquals($content[CURLOPT_RETURNTRANSFER], True);
        $this->assertEquals($content[CURLOPT_HTTPHEADER][0], "Expect:Dummy");
    }

    public function testOverrideOption()
    {

        $this->curl->setOption('CURLOPT_HTTPHEADER', array("Expect:Bar"));

        $method = new \ReflectionMethod($this->curl, 'getOptions');
        $method->setAccessible(true);
        $content = $method->invoke($this->curl);

        $_curl = new Curl($this->dummyConfigs);
        $_curl->setURL('http://bar_foo.com');

        $actual = $method->invoke($_curl);

        $this->assertNotEquals($content[CURLOPT_URL], $actual[CURLOPT_URL]);

        $this->assertEquals("Expect:Bar", $content[CURLOPT_HTTPHEADER][0]);
    }

    protected function tearDown()
    {
        $this->curl->__destruct();
    }

}

?>
