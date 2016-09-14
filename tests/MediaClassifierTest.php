<?php

/*
 * This file is part of the MimeSniffer package.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Temp\MediaClassifier\Tests\Model;

use Temp\MediaClassifier\MediaClassifier;
use Temp\MediaClassifier\Model\MediaType;
use Temp\MediaClassifier\Model\MediaTypeCollection;

/**
 * Media type collection test.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class MediaClassifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Temp\MediaClassifier\Exception\NotFoundException
     */
    public function testInvalidFallbackMediaType()
    {
        $mediaTypes = new MediaTypeCollection();
        $mediaTypes->add(new MediaType('gif', 'image', ['image/gif']));

        new MediaClassifier($mediaTypes, 'image:jpg');
    }

    public function testClassifyReturnsCorrectMediaType()
    {
        $mediaTypes = new MediaTypeCollection();
        $mediaTypes->add(new MediaType('binary', 'document'));
        $mediaTypes->add(new MediaType('gif', 'image', ['image/gif']));

        $classifier = new MediaClassifier($mediaTypes, 'image:gif');

        $mediaType = $classifier->classify(__DIR__.'/fixture/test.gif');

        $this->assertNotNull($mediaType);
        $this->assertSame('image:gif', (string) $mediaType);
    }

    public function testClassifyReturnsFallbackMediaType()
    {
        $mediaTypes = new MediaTypeCollection();
        $mediaTypes->add(new MediaType('binary', 'document'));

        $classifier = new MediaClassifier($mediaTypes, 'document:binary');

        $mediaType = $classifier->classify(__DIR__.'/fixture/test');

        $this->assertSame('document:binary', (string) $mediaType);
    }

    public function testGetCollection()
    {
        $mediaTypes = new MediaTypeCollection();
        $mediaTypes->add(new MediaType('gif', 'image', ['image/gif']));

        $classifier = new MediaClassifier($mediaTypes, 'image:gif');

        $this->assertSame($mediaTypes, $classifier->getCollection());
    }
}
