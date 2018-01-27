<?php
namespace DevOp\Core\Http\Test;

class UploadedFileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \DevOp\Core\Http\UploadedFile
     */
    private $uploadedFile;

    public function setUp()
    {
        $this->uploadedFile = new \DevOp\Core\Http\UploadedFile(new \DevOp\Core\Http\Stream('php://temp'), 3);
    }
    
    public function testConstructThrowException()
    {
        $this->setExpectedException('\RuntimeException');
        new \DevOp\Core\Http\UploadedFile(null, null);
    }
    
    public function testGetUploadedFileSize()
    {
        return $this->assertEquals(3, $this->uploadedFile->getSize());
    }
}
