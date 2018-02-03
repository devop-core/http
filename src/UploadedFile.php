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
     * @var string|resource
     */
    private $file;

    /**
     * @var StreamInterface
     */
    private $stream;

    /**
     * @var boolean
     */
    private $moved = false;

    /**
     * @param mixed $stream
     * @param int $size
     * @param int $error
     * @param string|null $clientFilename
     * @param string|null $clientMediaType
     * @throws \RuntimeException
     */
    public function __construct($stream, $size = 0, $error = UPLOAD_ERR_OK, $clientFilename = null, $clientMediaType = null)
    {
        if ($stream instanceof StreamInterface) {
            $this->stream = $stream;
        } else if (is_resource($stream)) {
            $this->stream = new Stream($stream);
        } else if (is_string($stream)) {
            $this->file = $stream;
        } else {
            throw new \RuntimeException('Invalid uploaded file.');
        }

        $this->size = $size;
        $this->error = $error;
        $this->clientFilename = $clientFilename;
        $this->clientMediaType = $clientMediaType;
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function createFromGlobal()
    {
        $normalize = [];
        foreach ($_FILES AS $key => $value) {
            if ($value instanceof UploadedFileInterface) {
                $normalize[$key] = $value;
            } else if (is_array($value) && isset($value['tmp_name'])) {
                $normalize[$key] = new UploadedFile($value['tmp_name'], $value['size'], $value['error'], $value['name'], $value['type']);
            } else {
                throw new \InvalidArgumentException('Invalid value in files specification');
            }
        }
        return $normalize;
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
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * @param mixed $targetPath
     * @throws \RuntimeException
     */
    public function moveTo($targetPath)
    {

        if (!is_dir($targetPath)) {
            throw new \RuntimeException('Invalid targetPath specified.');
        }

        if ($this->file && is_string($this->file)) {
            $this->moved = move_uploaded_file($this->file, $targetPath);
        } else if ($this->stream) {
            $this->moved = stream_copy_to_stream($this->stream->detach(), $targetPath) > 0;
        } else {
            throw new \RuntimeException('Invalid uploaded file.');
        }

        if (!$this->moved) {
            throw new \RuntimeException('Error  while uploading file.');
        }
    }
}
