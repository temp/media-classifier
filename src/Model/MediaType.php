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
 * Media type.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class MediaType
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $category;

    /**
     * @var array
     */
    private $mimetypes = [];

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var string
     */
    private $hash;

    /**
     * @param string $name
     * @param string $category
     * @param array  $mimetypes
     * @param array  $attributes
     */
    public function __construct($name, $category, array $mimetypes = [], array $attributes = [])
    {
        $this->name = $name;
        $this->category = $category;
        $this->mimetypes = $mimetypes;
        $this->attributes = $attributes;

        $this->hash = sha1($name.'-'.$category.'-'.implode('-', $mimetypes));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->category.':'.$this->name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return array
     */
    public function getMimetypes()
    {
        return $this->mimetypes;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $key
     * @param mixed  $defaultValue
     *
     * @return mixed
     */
    public function getAttribute($key, $defaultValue = null)
    {
        if (!isset($this->attributes[$key])) {
            return $defaultValue;
        }

        return $this->attributes[$key];
    }

    /**
     * @return string
     */
    public function getDefaultMimetype()
    {
        if (count($this->mimetypes)) {
            return reset($this->mimetypes);
        }

        return 'application/octet-stream';
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
}
