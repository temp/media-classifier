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
     * @var MimeSniffer
     */
    private $mimeSniffer;

    /**
     * @param MediaTypeCollection $mediaTypes
     * @param MimeSniffer         $mimeSniffer
     */
    public function __construct(MediaTypeCollection $mediaTypes, MimeSniffer $mimeSniffer)
    {
        $this->mediaTypes = $mediaTypes;
        $this->mimeSniffer = $mimeSniffer;
    }

    /**
     * @return MediaType|null
     */
    public function classify($filename)
    {
        $mimetype = $this->mimeSniffer->detect($filename, MimeSniffer::RETURN_STRING);

        return $this->mediaTypes->lookup($mimetype);
    }
}
