<?php
namespace DevOp\Core\Http\Factory;

use DevOp\Core\Http\UploadedFile;
use Interop\Http\Factory\UploadedFileFactoryInterface;

class UploadedFileFactory implements UploadedFileFactoryInterface
{

    /**
     * @param string $file
     * @param int $size
     * @param int $error
     * @param string|null $clientFilename
     * @param string|null $clientMediaType
     * @return \DevOp\Core\Http\UploadedFile
     */
    public function createUploadedFile($file, $size = 0, $error = \UPLOAD_ERR_OK, $clientFilename = null, $clientMediaType = null)
    {
        return new UploadedFile($file, $size, $error, $clientFilename, $clientMediaType);
    }
}
