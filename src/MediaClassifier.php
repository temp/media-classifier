<?php

/*
 * This file is part of the MimeSniffer package.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Temp\MediaClassifier;

use Symfony\Component\HttpFoundation\File\File;
use Temp\MediaClassifier\Exception\NotFoundException;
use Temp\MediaClassifier\Model\MediaType;
use Temp\MediaClassifier\Model\MediaTypeCollection;

/**
 * Media classifier.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class MediaClassifier
{
    /**
     * @var MediaTypeCollection
     */
    private $mediaTypes;

    /**
     * @param MediaTypeCollection $mediaTypes
     * @param string              $fallbackMediaType
     */
    public function __construct(MediaTypeCollection $mediaTypes, $fallbackMediaType)
    {
        $this->mediaTypes = $mediaTypes;

        if (!$this->mediaTypes->has($fallbackMediaType)) {
            throw new NotFoundException("Fallback media type $fallbackMediaType not defined.");
        }

        $this->fallbackMediaType = $fallbackMediaType;
    }

    /**
     * @return MediaType|null
     */
    public function classify($filename)
    {
        $file = new File($filename);
        $mimetype = $file->getMimeType();
        $mediaType = null;

        if ($mimetype) {
            $mediaType = $this->mediaTypes->lookup($mimetype);
        }

        if (!$mediaType) {
            $mediaType = $this->mediaTypes->get($this->fallbackMediaType);
        }

        return $mediaType;
    }

    /**
     * @return MediaTypeCollection
     */
    public function getCollection()
    {
        return $this->mediaTypes;
    }
}
