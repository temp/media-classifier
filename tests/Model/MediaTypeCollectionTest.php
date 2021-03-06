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
use Temp\MediaClassifier\Model\MediaTypeCollection;

/**
 * Media type collection test.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class MediaTypeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MediaTypeCollection
     */
    private $mediatypes;

    public function setUp()
    {
        $this->mediatypes = new MediaTypeCollection();
    }

    public function testAddViaConstructor()
    {
        $mediatypes = new MediaTypeCollection(
            [
                new MediaType('jpg', 'image'),
                new MediaType('mp4', 'video'),
            ]
        );

        $this->assertArrayHasKey('image:jpg', $mediatypes->all());
        $this->assertArrayHasKey('video:mp4', $mediatypes->all());
    }

    public function testAdd()
    {
        $this->mediatypes->add(new MediaType('jpg', 'image'));
        $this->mediatypes->add(new MediaType('mp4', 'video'));

        $this->assertArrayHasKey('image:jpg', $this->mediatypes->all());
        $this->assertArrayHasKey('video:mp4', $this->mediatypes->all());
    }

    public function testGet()
    {
        $this->mediatypes->add($mediaType = new MediaType('jpg', 'image'));

        $this->assertSame($mediaType, $this->mediatypes->get('image:jpg'));
    }

    public function testGetReturnsNullOnNotFound()
    {
        $this->assertNull($this->mediatypes->get('image:jpg'));
    }

    public function testRemove()
    {
        $this->mediatypes->add($jpg = new MediaType('jpg', 'image'));
        $this->mediatypes->add(new MediaType('mp4', 'video'));

        $this->mediatypes->remove($jpg);

        $this->assertArrayNotHasKey('image:jpg', $this->mediatypes->all());
    }

    public function testHas()
    {
        $this->mediatypes->add(new MediaType('mp4', 'video'));

        $this->assertTrue($this->mediatypes->has('video:mp4'));
    }

    public function testLookup()
    {
        $this->mediatypes->add($mp4 = new MediaType('mp4', 'video', ['video/mp4']));

        $result = $this->mediatypes->lookup('video/mp4');

        $this->assertSame($mp4, $result);
    }

    public function testLookupFindsLastOccurance()
    {
        $this->mediatypes->add(new MediaType('mp4', 'video', ['video/mp4']));
        $this->mediatypes->add($mpeg4 = new MediaType('mpeg4', 'video', ['video/mp4']));

        $result = $this->mediatypes->lookup('video/mp4');

        $this->assertSame($mpeg4, $result);
    }

    public function testMerge()
    {
        $mediatypes = new MediaTypeCollection();
        $mediatypes->add(new MediaType('mp4', 'video'));

        $this->mediatypes->merge($mediatypes);

        $this->assertTrue($this->mediatypes->has('video:mp4'));
    }

    public function testCount()
    {
        $this->mediatypes->add(new MediaType('jpg', 'image'));
        $this->mediatypes->add(new MediaType('mp4', 'video'));

        $this->assertSame(2, $this->mediatypes->count());
        $this->assertCount(2, $this->mediatypes);
    }

    public function testHash()
    {
        $mediaType = $this->prophesize('Temp\MediaClassifier\Model\MediaType');
        $mediaType->__toString()->willReturn('abc');
        $mediaType->getMimetypes()->willReturn([]);
        $mediaType->getHash()->willReturn('abc')->shouldBeCalled();

        $this->mediatypes->add($mediaType->reveal());

        $this->assertNotEmpty($this->mediatypes->getHash());
    }
}
