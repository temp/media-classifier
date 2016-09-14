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

use Temp\MediaClassifier\Model\MediaTypeCollection;

/**
 * Media type loader interface.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
interface LoaderInterface
{
    /**
     * Returns whether this class supports the given resource.
     *
     * @param string $file
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($file);

    /**
     * @param string $filename
     *
     * @return MediaTypeCollection
     */
    public function load($filename);
}
