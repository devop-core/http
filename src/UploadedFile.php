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
     * @var string
     */
    private $file;

    /**
     * @var \Psr\Http\Message\StreamInterface
     */
    private $stream;

    /**
     * @param string|resource|StreamInterface $stream
     * @param int $size
     * @param int $error
     * @param string|null $clientFilename
     * @param string|null $clientMediaType
     * @throws \RuntimeException
     */
    public function __construct($stream, $size, $error = UPLOAD_ERR_OK, $clientFilename = null, $clientMediaType = null)
    {
        if (is_string($stream) || is_resource($stream)) {
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
     * @param string|StreamInterface $targetPath
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
            $upload = stream_copy_to_stream($this->stream, $targetPath);
        } else {
            throw new \RuntimeException('Invalid uploaded file.');
        }

        if (!$upload) {
            throw new \RuntimeException('Erro while uploading file.');
        }
    }
}
