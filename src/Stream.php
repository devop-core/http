<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{

    /**
     * @var array
     */
    protected $modes = [
        'readable' => ['r', 'r+', 'w+', 'a+', 'x+', 'c+'],
        'writable' => ['r+', 'w', 'w+', 'a', 'a+', 'x', 'x+', 'c', 'c+'],
    ];

    /**
     * @var resource
     */
    private $handle;

    /**
     * @param resource $handle
     * @throws \InvalidArgumentException
     */
    public function __construct($handle)
    {
        if (!is_resource($this->handle) || get_resource_type($this->handle) !== 'stream') {
            throw new \InvalidArgumentException('Must be a stream');
        }

        $this->handle = $handle;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!$this->isReadable()) {
            return '';
        }

        if ($this->isSeekable()) {
            $this->rewind();
        }

        return stream_get_contents($this->handle);
    }

    /**
     * @return boolean
     */
    public function close()
    {
        if (!$this->handle) {
            return;
        }

        $handle = $this->detach();
        fclose($handle);
    }

    /**
     * @return resource
     */
    public function detach()
    {
        $handle = $this->handle;
        $this->handle = null;

        return $handle;
    }

    /**
     * @return boolean
     */
    public function eof()
    {
        if (!$this->handle) {
            return true;
        }

        return feof($this->handle);
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getContents()
    {
        if (!$this->handle) {
            throw new \RuntimeException('Empty stream');
        }

        if ($this->isReadable()) {
            throw new \RuntimeException('Unable to read stream');
        }

        return stream_get_contents($this->handle);
    }

    /**
     * @param string|key $key
     * @return mixed
     */
    public function getMetadata($key = null)
    {
        $metadata = stream_get_meta_data($this->handle);

        if (null === $key) {
            return $metadata;
        }

        if (isset($metadata[$key])) {
            return $metadata[$key];
        }

        return null;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        $fstats = fstat($this->handle);
        if (isset($fstats['size'])) {
            return $fstats['size'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isReadable()
    {
        if (!$this->handle) {
            return false;
        }

        $mode = $this->getMetadata('mode');
        return isset($this->modes['read'][$mode]);
    }

    /**
     * @return boolean
     */
    public function isSeekable()
    {
        if (!$this->handle) {
            return false;
        }

        if ($this->getMetadata('seekable')) {
            return true;
        }

        return false;
    }

    /**
     * @return boolean
     */
    public function isWritable()
    {
        if (!$this->handle) {
            return false;
        }

        $mode = $this->getMetadata('mode');
        return isset($this->modes['write'][$mode]);
    }

    /**
     * @param int $length
     * @return boolean
     * @throws \RuntimeException
     */
    public function read($length)
    {
        if (!$this->isReadable()) {
            throw new \RuntimeException('Stream is not readable');
        }

        return fread($this->handle, $length);
    }

    /**
     * @throws \RuntimeException
     */
    public function rewind()
    {
        if ($this->isSeekable()) {
            throw new \RuntimeException('Stream is not seekable');
        }

        $this->seek(0);
    }

    /**
     * @param int $offset
     * @param int $whence
     * @throws \RuntimeException
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        if (!$this->isSeekable()) {
            throw new \RuntimeException('Stream is not seekable');
        }

        return fseek($this->handle, $offset, $whence);
    }

    /**
     * @return int
     * @throws \RuntimeException
     */
    public function tell()
    {
        if (!$this->handle) {
            throw new \RuntimeException('Invalid stream handle');
        }

        return ftell($this->handle);
    }

    /**
     * @param string $string
     * @return int
     * @throws \RuntimeException
     */
    public function write($string)
    {
        if (!$this->isWritable()) {
            throw new \RuntimeException('Stream is not writable');
        }

        return fwrite($this->handle, $string);
    }
}
