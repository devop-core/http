<?php
namespace DevOp\Core\Http\Test\Factory;

use DevOp\Core\Http\Factory\UploadedFileFactory;

class UploadedFileFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateUploadedFile()
    {
        $uploadedFile = (new UploadedFileFactory())->createUploadedFile('php://temp', 0);
        $this->assertInstanceOf(\DevOp\Core\Http\UploadedFile::class, $uploadedFile);
    }
}
