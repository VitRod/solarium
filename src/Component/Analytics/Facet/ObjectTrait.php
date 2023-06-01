<?php

declare(strict_types=1);

/*
 * This file is part of the Solarium package.
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code.
 */

namespace Solarium\Component\Analytics\Facet;

use Solarium\Core\Configurable;
use Solarium\Exception\InvalidArgumentException;

/**
 * ObjectTrait.
 *
 * @author wicliff <wicliff.wolda@gmail.com>
 */
trait ObjectTrait
{
    /**
     * @param string            $class
     * @param array|object|null $variable
     *
     * @return mixed
     */
    public function ensureObject(string $class, $variable)
    {
        if (null === $variable) {
            return null;
        }

        if (\is_object($variable)
            && (\get_class($variable) === $class || is_subclass_of($variable, $class))
        ) {
            return $variable;
        }

        try {
            $refClass = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new InvalidArgumentException(sprintf('Class %s does not exists', $class));
        }

        if (\is_array($variable) && $refClass->isSubclassOf(Configurable::class)) {
            if (!$refClass->isAbstract()) {
                return new $class($variable);
            }

            if (isset($variable['type'])
                && (false !== $map = $refClass->getConstant('CLASSMAP'))
                && (isset($map[$variable['type']]))
            ) {
                $class = $map[$variable['type']];

                return new $class($variable);
            }
        }

        throw new InvalidArgumentException(sprintf('Unable to instantiate %s with %s', $class, \gettype($variable)));
    }
}
