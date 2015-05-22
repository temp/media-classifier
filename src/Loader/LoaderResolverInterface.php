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

/**
 * LoaderResolverInterface selects a loader for a given resource.
 *
 * @author Stephan Wentz <stephan@wentz.it>
 */
interface LoaderResolverInterface
{
    /**
     * Returns a loader able to load the resource.
     *
     * @param string $file
     *
     * @return LoaderInterface|false The loader or false if none is able to load the resource
     */
    public function resolve($file);
}
