<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{

    /**
     * @var array
     * @link http://php.net/manual/function.fopen.php
     */
    protected $modes = [
        'readable' => [
            'r' => true, 'w+' => true, 'r+' => true, 'x+' => true, 'c+' => true,
            'rb' => true, 'w+b' => true, 'r+b' => true, 'x+b' => true,
            'c+b' => true, 'rt' => true, 'w+t' => true, 'r+t' => true,
            'x+t' => true, 'c+t' => true, 'a+' => true
        ],
        'writable' => [
            'w' => true, 'w+' => true, 'rw' => true, 'r+' => true, 'x+' => true,
            'c+' => true, 'wb' => true, 'w+b' => true, 'r+b' => true,
            'x+b' => true, 'c+b' => true, 'w+t' => true, 'r+t' => true,
            'x+t' => true, 'c+t' => true, 'a' => true, 'a+' => true
        ],
    ];

    /**
     * @var resource
     */
    private $stream;

    /**
     * @param resource|string $handle
     * @param string|null $mode
     * @throws \InvalidArgumentException
     */
    public function __construct($handle, $mode = 'r')
    {

        if (is_string($handle)) {
            $handle = fopen($handle, $mode);
        }

        if (!is_resource($handle)) {
            throw new \InvalidArgumentException('Argument must be a valid stream.');
        }

        $this->stream = $handle;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        try {
            if ($this->isSeekable()) {
                $this->rewind();
            }
            return $this->getContents();
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * @return boolean
     */
    public function close()
    {
        if (!$this->stream) {
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
        $handle = $this->stream;
        $this->stream = null;

        return $handle;
    }

    /**
     * @return boolean
     */
    public function eof()
    {
        if (!$this->stream) {
            return true;
        }

        return feof($this->stream);
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getContents()
    {
        if (!$this->stream) {
            throw new \RuntimeException('Empty stream');
        }

        if ($this->isReadable()) {
            throw new \RuntimeException('Unable to read stream');
        }

        return (string) stream_get_contents($this->stream);
    }

    /**
     * @param string|key $key
     * @return mixed
     */
    public function getMetadata($key = null)
    {
        $metadata = stream_get_meta_data($this->stream);

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
        $fstats = fstat($this->stream);
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
        if (!$this->stream) {
            return false;
        }

        $mode = $this->getMetadata('mode');
        return isset($this->modes['readable'][$mode]);
    }

    /**
     * @return boolean
     */
    public function isSeekable()
    {
        if (!$this->stream) {
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
        if (!$this->stream) {
            return false;
        }

        $mode = $this->getMetadata('mode');
        return isset($this->modes['writable'][$mode]);
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

        return fread($this->stream, $length);
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

        return fseek($this->stream, $offset, $whence);
    }

    /**
     * @return int
     * @throws \RuntimeException
     */
    public function tell()
    {
        if (!$this->stream) {
            throw new \RuntimeException('Invalid stream handle');
        }

        return ftell($this->stream);
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

        return fwrite($this->stream, $string);
    }
}
