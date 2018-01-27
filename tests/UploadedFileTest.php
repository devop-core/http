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
        $this->uploadedFile = new \DevOp\Core\Http\UploadedFile(new \DevOp\Core\Http\Stream('php://temp'), 2, UPLOAD_ERR_OK, 'tempnam', '');
    }
    
    public function testConstructThrowException()
    {
        $this->setExpectedException('\RuntimeException');
        new \DevOp\Core\Http\UploadedFile(null, null);
    }
    
    public function testGetUploadedFileSize()
    {
        $this->assertEquals(2, $this->uploadedFile->getSize());
        $this->assertEquals(UPLOAD_ERR_OK, $this->uploadedFile->getError());
        $this->assertEquals('tempnam', $this->uploadedFile->getClientFilename());
        $this->assertEquals('', $this->uploadedFile->getClientMediaType());
    }
}
