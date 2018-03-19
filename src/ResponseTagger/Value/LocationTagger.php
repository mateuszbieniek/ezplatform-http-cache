<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\PlatformHttpCacheBundle\ResponseTagger\Value;

use eZ\Publish\API\Repository\Values\ValueObject;
use eZ\Publish\API\Repository\Values\Content\Location;
use EzSystems\PlatformHttpCacheBundle\Handler\TagHandlerInterface;
use EzSystems\PlatformHttpCacheBundle\ResponseTagger\ValueTaggerInterface;

class LocationTagger implements ValueTaggerInterface
{
    public function tag(TagHandlerInterface $tagHandler, ValueObject $value)
    {
        if (!$value instanceof Location) {
            return $this;
        }

        if ($value->id !== $value->contentInfo->mainLocationId) {
            $tagHandler->addTags(['location-' . $value->id]);
        }

        $tagHandler->addTags(['parent-' . $value->parentLocationId]);
        $tagHandler->addTags(
            array_map(
                function ($pathItem) {
                    return 'path-' . $pathItem;
                },
                $value->path
            )
        );

        return $this;
    }
}
