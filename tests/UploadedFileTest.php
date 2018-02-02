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
        $stream = (new \DevOp\Core\Http\Factory\StreamFactory())->createStream('test');
        $this->uploadedFile = new \DevOp\Core\Http\UploadedFile($stream, 4, UPLOAD_ERR_OK, 'tempnam', '');
    }
    
    public function testConstructThrowException()
    {
        $this->setExpectedException('\RuntimeException');
        new \DevOp\Core\Http\UploadedFile(null, null);
    }
    
    public function testGetUploadedFileSize()
    {
        $this->assertEquals(4, $this->uploadedFile->getSize());
        $this->assertEquals(UPLOAD_ERR_OK, $this->uploadedFile->getError());
        $this->assertEquals('tempnam', $this->uploadedFile->getClientFilename());
        $this->assertEquals('', $this->uploadedFile->getClientMediaType());
    }
}
