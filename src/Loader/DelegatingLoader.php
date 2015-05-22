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

use Temp\MediaClassifier\Exception\LoadException;

/**
 * DelegatingLoader delegates loading to other loaders using a loader resolver.
 *
 * This loader acts as an array of LoaderInterface objects - each having
 * a chance to load a given resource (handled by the resolver)
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DelegatingLoader implements LoaderInterface
{
    /**
     * @var LoaderResolverInterface
     */
    private $resolver;

    /**
     * Constructor.
     *
     * @param LoaderResolverInterface $resolver A LoaderResolverInterface instance
     */
    public function __construct(LoaderResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource)
    {
        if (false === $loader = $this->resolver->resolve($resource)) {
            throw new LoadException($resource);
        }

        return $loader->load($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource)
    {
        return false !== $this->resolver->resolve($resource);
    }
}
