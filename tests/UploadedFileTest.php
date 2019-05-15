<?php
namespace DevOp\Core\Http\Test;

use PHPUnit\Framework\TestCase;

class UploadedFileTest extends TestCase
{

    /**
     * @var \DevOp\Core\Http\UploadedFile
     */
    private $uploadedFile;

    public function setUp()
    {
        $stream = (new \DevOp\Core\Http\StreamFactory())->createStream('test');
        $this->uploadedFile = new \DevOp\Core\Http\UploadedFile($stream, 4, UPLOAD_ERR_OK, 'tempnam', '');
    }

    public function testConstructThrowException()
    {
        $this->expectException('\RuntimeException');
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
