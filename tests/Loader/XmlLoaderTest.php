<?php

/*
 * This file is part of the MimeSniffer package.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Temp\MediaClassifier\Tests\Loader;

use org\bovigo\vfs\vfsStream;
use Temp\MediaClassifier\Loader\XmlLoader;

/**
 * XML loader test
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
class XmlLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XmlLoader
     */
    private $loader;

    public function setUp()
    {
        $this->loader = new XmlLoader();
    }

    /**
     * {@inheritdoc}
     */
    public function testLoad()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<mediatypes>
    <mediatype name="mp4" category="video">
        <mimetypes>
            <mimetype>video/mp4</mimetype>
        </mimetypes>
    </mediatype>
    <mediatype name="jpg" category="image">
        <mimetypes>
            <mimetype>image/jpg</mimetype>
            <mimetype>image/jpeg</mimetype>
        </mimetypes>
    </mediatype>
</mediatypes>
EOF;
        vfsStream::setup('root', null, array('types.xml' => $xml));

        $mediatypes = $this->loader->load(vfsStream::url('root/types.xml'));

        $this->assertCount(2, $mediatypes);

        $this->assertTrue($mediatypes->has('mp4'));
        $this->assertSame('mp4', $mediatypes->get('mp4')->getName());
        $this->assertSame('video', $mediatypes->get('mp4')->getCategory());
        $this->assertCount(1, $mediatypes->get('mp4')->getMimetypes());
        $this->assertSame(array('video/mp4'), $mediatypes->get('mp4')->getMimetypes());

        $this->assertTrue($mediatypes->has('jpg'));
        $this->assertSame('jpg', $mediatypes->get('jpg')->getName());
        $this->assertSame('image', $mediatypes->get('jpg')->getCategory());
        $this->assertCount(2, $mediatypes->get('jpg')->getMimetypes());
        $this->assertSame(array('image/jpg', 'image/jpeg'), $mediatypes->get('jpg')->getMimetypes());
    }

}
