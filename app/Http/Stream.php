<?php

namespace AndrewSvirin\Interview\Http;

use Psr\Http\Message\StreamInterface;
use RuntimeException;

/**
 * Http stream model implementation.
 */
class Stream implements StreamInterface
{

    /**
     * Stream.
     *
     * @var resource
     */
    protected $resource;

    /**
     * Stream constructor.
     *
     * @param resource $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        $this->rewind();

        return $this->getContents();
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        fclose($this->resource);
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        throw new RuntimeException('Not implemented method detach().');
    }

    /**
     * @inheritDoc
     */
    public function getSize()
    {
        $fstat = fstat($this->resource);

        return is_array($fstat) ? $fstat['size'] : null;
    }

    /**
     * @inheritDoc
     */
    public function tell()
    {
        throw new RuntimeException('Not implemented method tell().');
    }

    /**
     * @inheritDoc
     */
    public function eof()
    {
        return feof($this->resource);
    }

    /**
     * @inheritDoc
     */
    public function isSeekable()
    {
        return $this->getMetadata('seekable');
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        fseek($this->resource, $offset, $whence);
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function rewind()
    {
        rewind($this->resource);
    }

    /**
     * @inheritDoc
     */
    public function isWritable()
    {
        $mode = $this->getMetadata('mode');

        return strstr($mode, 'x') ||
            strstr($mode, 'w') ||
            strstr($mode, 'c') ||
            strstr($mode, 'a') ||
            strstr($mode, '+');
    }

    /**
     * @inheritDoc
     */
    public function write($string)
    {
        $result = fwrite($this->resource, $string);

        if (false === $result) {
            throw new RuntimeException('Stream was not written.');
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function isReadable()
    {
        $mode = $this->getMetadata('mode');

        return strstr($mode, 'r') || strstr($mode, '+');
    }

    /**
     * @inheritDoc
     */
    public function read($length)
    {
        throw new RuntimeException('Not implemented method read().');
    }

    /**
     * @inheritDoc
     */
    public function getContents()
    {
        $result = stream_get_contents($this->resource);

        if (false === $result) {
            throw new RuntimeException('Stream was not read.');
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        $metadata = stream_get_meta_data($this->resource);
        if (null === $key) {
            return $metadata;
        }
        return $metadata[$key] ?? null;
    }
}
