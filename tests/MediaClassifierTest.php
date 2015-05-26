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

use Prophecy\Argument;
use Temp\MediaClassifier\MediaClassifier;
use Temp\MediaClassifier\Model\MediaType;
use Temp\MediaClassifier\Model\MediaTypeCollection;
use Temp\MimeSniffer\MimeSniffer;

/**
 * Media type collection test
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class MediaClassifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MediaClassifier
     */
    private $classifier;

    public function setUp()
    {
        $mediaTypes = new MediaTypeCollection();
        $mediaTypes->add(new MediaType('php', 'text', array('text/x-php')));

        $this->classifier = new MediaClassifier($mediaTypes);
    }

    public function testClassifiy()
    {
        $mediaType = $this->classifier->classify(__FILE__);

        $this->assertNotNull($mediaType);
        $this->assertSame('php', $mediaType->getName());
    }
}
