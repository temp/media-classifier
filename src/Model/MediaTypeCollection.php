<?php

/*
 * This file is part of the MimeSniffer package.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Temp\MediaClassifier\Model;

/**
 * Media type collection
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class MediaTypeCollection implements \Countable
{
    /**
     * @var MediaType[]
     */
    private $mediaTypes = array();

    /**
     * @var array
     */
    private $mimetypeMap = array();

    /**
     * Constructor.
     *
     * @param array $mediaTypes
     */
    public function __construct(array $mediaTypes = array())
    {
        foreach ($mediaTypes as $mediaType) {
            $this->add($mediaType);
        }
    }

    /**
     * Add media type
     *
     * @param MediaType $mediaType
     *
     * @return $this
     */
    public function add(MediaType $mediaType)
    {
        $this->mediaTypes[(string) $mediaType] = $mediaType;

        foreach ($mediaType->getMimetypes() as $mimetype) {
            $this->mimetypeMap[$mimetype] = (string) $mediaType;
        }

        return $this;
    }

    /**
     * Merge collection
     *
     * @param MediaTypeCollection $collection
     *
     * @return $this
     */
    public function merge(MediaTypeCollection $collection)
    {
        foreach ($collection->all() as $mediaType) {
            $this->add($mediaType);
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return MediaType
     */
    public function get($name)
    {
        if ($this->has($name)) {
            return $this->mediaTypes[$name];
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->mediaTypes[$name]);
    }

    /**
     * @param MediaType $mediaType
     *
     * @return $this
     */
    public function remove(MediaType $mediaType)
    {
        if ($this->has((string) $mediaType)) {
            unset($this->mediaTypes[(string) $mediaType]);
        }

        return null;
    }

    /**
     * @return MediaType[]
     */
    public function all()
    {
        return $this->mediaTypes;
    }

    /**
     * @param string $mimetype
     *
     * @return MediaType|null
     */
    public function lookup($mimetype)
    {
        if (isset($this->mimetypeMap[$mimetype])) {
            return $this->get($this->mimetypeMap[$mimetype]);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        $hashes = array();
        foreach ($this->mediaTypes as $mediaType) {
            $hashes[] = $mediaType->getHash();
        }

        return sha1(implode('-', $hashes));
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->mediaTypes);
    }
}
