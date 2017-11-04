<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFile implements UploadedFileInterface
{

    /**
     * @var string
     */
    private $clientFilename;

    /**
     * @var string
     */
    private $clientMediaType;

    /**
     *
     * @var int
     */
    private $error;

    /**
     * @var int 
     */
    private $size;

    /**
     * @var resource
     */
    private $file;

    /**
     * @var \Psr\Http\Message\StreamInterface
     */
    private $stream;

    /**
     * @param StreamInterface $stream
     * @param int $size
     * @param int $error
     * @param string|null $clientFilename
     * @param string|null $clientMediaType
     * @throws \RuntimeException
     */
    public function __construct($stream, $size, $error = UPLOAD_ERR_OK, $clientFilename = null, $clientMediaType = null)
    {
        if (is_string($stream)) {
            $this->file = $stream;
        } else if (is_resource($stream)) {
            $this->stream = new Stream($stream);
        } else if ($stream instanceof StreamInterface) {
            $this->stream = $stream;
        } else {
            throw new \RuntimeException('Invalid uploaded file.');
        }

        $this->size = $size;
        $this->error = $error;
        $this->clientFilename = $clientFilename;
        $this->clientMediaType = $clientMediaType;
    }

    /**
     * @return string
     */
    public function getClientFilename()
    {
        return $this->clientFilename;
    }

    /**
     * @return string
     */
    public function getClientMediaType()
    {
        return $this->clientMediaType;
    }

    /**
     * @return int
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return resource
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * @param string $targetPath
     * @throws \RuntimeException
     */
    public function moveTo($targetPath)
    {
        
        if (!is_dir($targetPath)) {
            throw new \RuntimeException('Invalid targetPath specified.');
        }
        
        if ($this->file) {
            $upload = move_uploaded_file($this->file, $targetPath);
        } else if ($this->stream) {
            $upload = copy_to_stream($this->stream, $targetPath);
        } else {
            throw new \RuntimeException('Invalid uploaded file.');
        }
        
        if (!$upload) {
            throw new \RuntimeException('Erro while uploading file.');
        }
    }
}
