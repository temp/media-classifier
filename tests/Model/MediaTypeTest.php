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

use Temp\MediaClassifier\Model\MediaType;

/**
 * Media type test.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class MediaTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testHash()
    {
        $mediaType1 = new MediaType('jpg', 'image');
        $mediaType2 = new MediaType('mp4', 'video');
        $mediaType3 = new MediaType('mp4', 'video');

        $this->assertNotSame($mediaType1->getHash(), $mediaType2->getHash());
        $this->assertSame($mediaType2->getHash(), $mediaType3->getHash());
    }

    public function testDefaultMimetype()
    {
        $mediaType = new MediaType('jpg', 'image', ['image/jpeg', 'image/jpg']);

        $this->assertSame('image/jpeg', $mediaType->getDefaultMimetype());
    }

    public function testDefaultMimetypeFallsBackToApplicationOctetStream()
    {
        $mediaType = new MediaType('binary', 'document');

        $this->assertSame('application/octet-stream', $mediaType->getDefaultMimetype());
    }
}
