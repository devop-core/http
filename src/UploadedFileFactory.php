<?php
namespace DevOp\Core\Http;

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
    public function createUploadedFile($file, $size = null, $error = UPLOAD_ERR_OK, $clientFilename = null, $clientMediaType = null)
    {
        return new UploadedFile($file, $size, $error, $clientFilename, $clientMediaType);
    }
}
