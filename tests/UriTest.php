<?php
namespace DevOp\Core\Http\Test;

class UriTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \DevOp\Core\Http\Uri
     */
    private $uri;

    public function setUp()
    {
        $this->uri = new \DevOp\Core\Http\Uri();
    }

    public function testWithFragment()
    {
        $uri = $this->uri->withFragment('#home');
        $this->assertEquals('#home', $uri->getFragment());
    }
}
