<?php

namespace ContactFormProxyIp\Test;

use ContactFormProxyIp\Main;
use Mockery;
use WP_Mock;

class MainTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        WP_Mock::setUp();
        WP_Mock::wpFunction('wp_enqueue_style');
        $this->submissionMock = Mockery::mock('overload:WPCF7_Submission');
    }

    public function tearDown()
    {
        WP_Mock::tearDown();
        Mockery::close();
    }

    public function testAddSpecialTagsWithWrongTag()
    {
        $this->submissionMock->shouldReceive('get_instance')->andReturn(new \WPCF7_Submission());
        $this->assertEmpty(Main::addSpecialTags('', '_remote_ip', false));
    }

    public function testAddSpecialTagsWithoutSubmission()
    {
        $this->submissionMock->shouldReceive('get_instance');
        $this->assertEmpty(Main::addSpecialTags('', '_forwarded_ip', false));
    }

    public function testAddSpecialTagsWithoutRemoteIp()
    {
        $this->submissionMock->shouldReceive('get_meta');
        $this->submissionMock->shouldReceive('get_instance')->andReturn(new \WPCF7_Submission());
        $this->assertEmpty(Main::addSpecialTags('', '_forwarded_ip', false));
    }

    public function testAddSpecialTagsWithRemoteIp()
    {
        $this->submissionMock->shouldReceive('get_meta')->andReturn('127.0.0.1');
        $this->submissionMock->shouldReceive('get_instance')->andReturn(new \WPCF7_Submission());
        $this->assertEquals('127.0.0.1', Main::addSpecialTags('', '_forwarded_ip', false));
    }

    public function testAddSpecialTagsWithForwardedIp()
    {
        $_SERVER['HTTP_X_FORWARDED_FOR'] = '127.0.0.1';
        $this->submissionMock->shouldReceive('get_instance')->andReturn(new \WPCF7_Submission());
        $this->assertEquals('127.0.0.1', Main::addSpecialTags('', '_forwarded_ip', false));
    }
}
