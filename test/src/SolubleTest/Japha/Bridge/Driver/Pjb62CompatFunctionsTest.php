<?php

use Soluble\Japha\Bridge\Adapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-11-04 at 16:47:42.
 */
class Pjb62CompatFunctionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $servlet_address;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        \SolubleTestFactories::startJavaBridgeServer();
        $this->servlet_address = \SolubleTestFactories::getJavaBridgeServerAddress();
        // Just launch the adapter
        $adapter = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
        ]);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testCompatFunctions()
    {
        $i1 = new Java('java.math.BigInteger', 1);
        $i2 = new Java('java.math.BigInteger', 2);

        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb62\Java', $i2);

        $i3 = $i1->add($i2);
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb62\InternalJava', $i3);
        $this->assertTrue(java_instanceof($i1, java_class('java.math.BigInteger')));

        $this->assertTrue(java_instanceof($i3, 'java.math.BigInteger'));

        $this->assertEquals('3', $i3->toString());

        $params = java_class('java.util.HashMap');
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb62\Java', $params);
        //$this->assertEquals('java.util.HashMap', $params->get__signature());

        $util = java_class('php.java.bridge.Util');

        $ctx = java_context();
        /* get the current instance of the JavaBridge, ServletConfig and Context */
        $bridge = $ctx->getAttribute('php.java.bridge.JavaBridge', 100);
        $config = $ctx->getAttribute('php.java.servlet.ServletConfig', 100);
        $context = $ctx->getAttribute('php.java.servlet.ServletContext', 100);
        $servlet = $ctx->getAttribute('php.java.servlet.Servlet', 100);

        $inspected = java_inspect($bridge);
        $this->assertInternalType('string', $inspected);
        $this->assertContains('php.java.bridge.JavaBridge.getCachedString', $inspected);
    }

    /**
     *  Here are placed some tests found in the original php-java-bridge tests suite
     *  and converted in phpunit.
     */
    public function testOriginalCases()
    {
        // Found in test.php5/testClass.php
        $cls = java_class('java.lang.Class');
        $arr = java_get_values($cls->getConstructors());
        $this->assertEquals(0, count($arr));

        // Found in test.php5/sendHash.php
        $h = ['k' => 'v', 'k2' => 'v2'];
        $m = new java('java.util.HashMap', $h);
        $this->assertEquals(2, $m->size());
        $this->assertEquals('v', $m['k']);
        $this->assertEquals('v2', $m['k2']);

        // Found in test.php5/sendArray.php
        $ar = [1, 2, 3, 5, 7, 11, -13, -17.01, 19];
        unset($ar[1]);

        $v = new java('java.util.Vector', $ar);
        $Arrays = new java_class('java.util.Arrays');
        $l = $Arrays->asList($ar);
        $v->add(1, null);

        $l2 = $v->sublist(0, $v->size());

        $this->assertEquals('[1, null, 3, 5, 7, 11, -13, -17.01, 19]', java_cast($l, 'S'));
        $this->assertEquals('[1, null, 3, 5, 7, 11, -13, -17.01, 19]', java_cast($l2, 'S'));

        $res1 = java_values($l);
        $res2 = java_values($l2);
        $res3 = [];
        $res4 = [];
        $i = 0;

        foreach ($v as $key => $val) {
            $res3[$i++] = java_values($val);
        }
        for ($i = 0; $i < java_values($l2->size()); ++$i) {
            $res4[$i] = java_values($l2[$i]);
        }
        $this->assertTrue($l->equals($l2));
        $this->assertNull(java_values($l[1]));
        $this->assertEquals($res3, $res1);
        $this->assertEquals($res4, $res1);

        // foudn in test.php5/vector.php
        $v = new java('java.util.Vector');
        $v->setSize(10);

        foreach ($v as $key => $val) {
            $v[$key] = $key;
        }
        foreach ($v as $key => $val) {
            $this->assertEquals($key, java_values($val));
        }
        for ($i = 0; $i < 10; ++$i) {
            $this->assertEquals($i, java_values($v[$i]));
        }

        // Found in test.php5/toString.php
        $Object = new java_class('java.lang.Object');
        $ObjectC = new JavaClass('java.lang.Object');
        $object = $Object->newInstance();

        $this->assertEquals('class java.lang.Object', (string) $Object);
        $this->assertEquals('class java.lang.Object', $Object->__toString());

        $this->assertStringStartsWith('java.lang.Object@', $object->__toString());
    }

    public function testUTF8()
    {
        $utf8_string = 'Cześć! -- שלום -- Grüß Gott -- Dobrý deň -- Dobrý den -- こんにちは, ｺﾝﾆﾁﾊ';
        //java_set_file_encoding("ASCII");
        $string = new Java('java.lang.String', $utf8_string, 'UTF-8');
        $this->assertEquals($utf8_string, $string->getBytes('UTF-8'));
    }

    public function testOutputStream()
    {
        $file_encoding = 'ASCII';
        java_set_file_encoding($file_encoding);

        $out = new java('java.io.ByteArrayOutputStream');
        $stream = new java('java.io.PrintStream', $out);
        $str = new java('java.lang.String', 'Cześć! -- שלום -- Grüß Gott', 'UTF-8');

        $stream->print($str);
        $this->assertEquals('Cze??! -- ???? -- Gr?? Gott', $out->__toString());
        $this->assertEquals('Cze??! -- ???? -- Gr?? Gott', java_values($out->toString()));
        $this->assertEquals('Cześć! -- שלום -- Grüß Gott', java_cast($out->toByteArray(), 'S'));
    }

    public function testJavaServerName()
    {
        $jsn = java_server_name();
        $this->assertNotEmpty($jsn);
        $this->assertContains($jsn, $this->servlet_address);
    }

    public function testValues()
    {
        $false = new Java('java.lang.Boolean', false);
        $this->assertTrue(java_is_false($false));
        $this->assertFalse(java_is_true($false));

        $true = new Java('java.lang.Boolean', true);
        $this->assertFalse(java_is_false($true));
        $this->assertTrue(java_is_true($true));

        $string = new Java('java.lang.String');
        $this->assertFalse(java_is_null($string));
        $this->assertFalse(java_isnull($string));
        $this->assertFalse(java_is_true($string));
        $this->assertFalse(java_istrue($string));
        // Warning: originally java_is_false contained a long standing issue: an empty string
        // is considered as false. To not break compatibility it's remaining like this
        $this->assertTrue(java_isfalse($string));
        $this->assertTrue(java_is_false($string));

        $string2 = new Java('java.lang.String', 'Hello');
        $this->assertFalse(java_isfalse($string2));
        $this->assertFalse(java_is_false($string2));

        $s = new JavaClass('java.lang.System');
        $null = $s->getProperty('foo');
        // null is php type null
        $this->assertNull($null);
        $this->assertTrue(java_is_null($null));
        $this->assertTrue(java_is_false($null));
        $this->assertFalse(java_is_true($null));
    }

    public function testNotPassing()
    {
        $this->markTestSkipped('Test todo before releasing version 1');

        // Test taken from utf8-3
        $utf8_string = 'Héélàù &éùµ$*';
        $iso_string = iconv('utf8', 'iso-8859-1', $utf8_string);
        $string = new Java('java.lang.String', '', 'ISO-8859-1');
        $this->assertEquals($utf8_string, java_values($string->getBytes('UTF-8')));

        // Test taken from test.php5/nestedArrays
        $v = new java('java.util.Vector');
        $ar = ['one' => 1, 'two' => 2, 'three' => 3, ['a', [1, 2, 3, ['a', 'b'], 5, 'c', 'd'], 'five' => 5, 'six' => 6]];
        $v->add($ar);

        $this->assertInternalType('array', java_values($v));
        $result = array_diff_assoc(java_values($v), [$ar]);

        $this->assertEquals(0, count($result));
    }
}
