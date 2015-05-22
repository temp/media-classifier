<?php

/*
 * This file is part of the MimeSniffer package.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Temp\MediaClassifier\Loader;

use Temp\MediaClassifier\Model\MediaType;
use Temp\MediaClassifier\Model\MediaTypeCollection;

/**
 * XML media type loader
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class XmlLoader implements LoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports($file)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function load($filename)
    {
        $mediaTypes = new MediaTypeCollection();

        $xml = simplexml_load_file($filename);

        foreach ($xml->mediatype as $mediatypeNode) {
            $attrs = $mediatypeNode->attributes();
            $name = (string) $attrs['name'];
            $category = (string) $attrs['category'];

            $mimetypes = array();
            if ($mediatypeNode->mimetypes->count() && $mediatypeNode->mimetypes->mimetype->count()) {
                foreach ($mediatypeNode->mimetypes->mimetype as $mimetypeNode) {
                    $mimetypes[] = (string) $mimetypeNode;
                }
            }

            $mediaType = new MediaType($name, $category, $mimetypes);

            $mediaTypes->add($mediaType);
        }

        return $mediaTypes;
    }
}
