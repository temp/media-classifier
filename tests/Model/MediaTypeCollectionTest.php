<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Temp\MediaClassifier\Tests\Model;

use Temp\MediaClassifier\Model\MediaType;
use Temp\MediaClassifier\Model\MediaTypeCollection;

/**
 * Media type collection test
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

    public function testAdd()
    {
        $this->mediatypes->add(new MediaType('jpg', 'image'));
        $this->mediatypes->add(new MediaType('mp4', 'video'));

        $this->assertArrayHasKey('jpg', $this->mediatypes->all());
        $this->assertArrayHasKey('mp4', $this->mediatypes->all());
    }

    public function testRemove()
    {
        $this->mediatypes->add($jpg = new MediaType('jpg', 'image'));
        $this->mediatypes->add(new MediaType('mp4', 'video'));

        $this->mediatypes->remove($jpg);

        $this->assertArrayNotHasKey('jpg', $this->mediatypes->all());
    }

    public function testHas()
    {
        $this->mediatypes->add(new MediaType('mp4', 'video'));

        $this->assertTrue($this->mediatypes->has('mp4'));
    }

    public function testLookup()
    {
        $this->mediatypes->add($mp4 = new MediaType('mp4', 'video', array('video/mp4')));

        $result = $this->mediatypes->lookup('video/mp4');

        $this->assertSame($mp4, $result);
    }

    public function testLookupFindsLastOccurance()
    {
        $this->mediatypes->add(new MediaType('mp4', 'video', array('video/mp4')));
        $this->mediatypes->add($mpeg4 = new MediaType('mpeg4', 'video', array('video/mp4')));

        $result = $this->mediatypes->lookup('video/mp4');

        $this->assertSame($mpeg4, $result);
    }

    public function testMerge()
    {
        $mediatypes = new MediaTypeCollection();
        $mediatypes->add(new MediaType('mp4', 'video'));

        $this->mediatypes->merge($mediatypes);

        $this->assertTrue($this->mediatypes->has('mp4'));
    }

    public function testCount()
    {
        $this->mediatypes->add(new MediaType('jpg', 'image'));
        $this->mediatypes->add(new MediaType('mp4', 'video'));

        $this->assertSame(2, $this->mediatypes->count());
        $this->assertCount(2, $this->mediatypes);
    }
}
