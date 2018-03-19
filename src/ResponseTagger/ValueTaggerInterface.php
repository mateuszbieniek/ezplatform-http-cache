<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\PlatformHttpCacheBundle\ResponseTagger;

use eZ\Publish\API\Repository\Values\ValueObject;
use EzSystems\PlatformHttpCacheBundle\Handler\TagHandlerInterface;

/**
 * Tags a Response based on data from a value object.
 */
interface ValueTaggerInterface
{
    /**
     * @param TagHandlerInterface $tagHandler
     * @param ValueObject $value
     *
     * @return $this
     */
    public function tag(TagHandlerInterface $tagHandler, ValueObject $value);
}
