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
use Temp\MediaClassifier\Model\MediaType;
use Temp\MediaClassifier\Model\MediaTypeCollection;
use Temp\MimeSniffer\MimeSniffer;

/**
 * Media classifier
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
     */
    public function __construct(MediaTypeCollection $mediaTypes)
    {
        $this->mediaTypes = $mediaTypes;
    }

    /**
     * @return MediaType|null
     */
    public function classify($filename)
    {
        $file = new File($filename);
        $mimetype = $file->getMimeType();

        if (!$mimetype) {
            return null;
        }

        return $this->mediaTypes->lookup((string) $mimetype);
    }
}
