<?php
include_once "..\public\index.php";

class SessionTest extends \PHPUnit\Framework\TestCase
{
    public function testSet()
    {
        $session = new \app\services\Session();
        $session->set('test', 111);
        $this->assertEquals(111, $session->get('test'));
    }

    public function testIsSet()
    {
        $session = new \app\services\Session();
        $this->assertIsBool($session->isSet('test'));
        $this->assertTrue($session->isSet('test'));
    }

    public function testClear()
    {
        $session = new \app\services\Session();
        $session->clear('test');
        $this->assertFalse($session->isSet('test'));
    }

    public function testClose()
    {
        $session = new \app\services\Session();
        $session->set('test1', 111);
        $session->set('test2', 222);
        $session->close();
        $this->assertFalse($session->isSet('test1'));
        $this->assertFalse($session->isSet('test2'));
    }
}