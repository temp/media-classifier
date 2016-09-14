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
 * XML loader test.
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

    public function testSupports()
    {
        $this->assertTrue($this->loader->supports('file'));
    }

    /**
     * {@inheritdoc}
     */
    public function testLoad()
    {
        $xml = <<<'EOF'
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
        vfsStream::setup('root', null, ['types.xml' => $xml]);

        $mediatypes = $this->loader->load(vfsStream::url('root/types.xml'));

        $this->assertCount(2, $mediatypes);

        $this->assertTrue($mediatypes->has('video:mp4'));
        $this->assertSame('mp4', $mediatypes->get('video:mp4')->getName());
        $this->assertSame('video', $mediatypes->get('video:mp4')->getCategory());
        $this->assertCount(1, $mediatypes->get('video:mp4')->getMimetypes());
        $this->assertSame(['video/mp4'], $mediatypes->get('video:mp4')->getMimetypes());

        $this->assertTrue($mediatypes->has('image:jpg'));
        $this->assertSame('jpg', $mediatypes->get('image:jpg')->getName());
        $this->assertSame('image', $mediatypes->get('image:jpg')->getCategory());
        $this->assertCount(2, $mediatypes->get('image:jpg')->getMimetypes());
        $this->assertSame(['image/jpg', 'image/jpeg'], $mediatypes->get('image:jpg')->getMimetypes());
    }
}
