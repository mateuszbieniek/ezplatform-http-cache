<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\PlatformHttpCacheBundle\ResponseTagger\Value;

use eZ\Publish\API\Repository\Values\ValueObject;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use EzSystems\PlatformHttpCacheBundle\Handler\TagHandlerInterface;
use EzSystems\PlatformHttpCacheBundle\ResponseTagger\ValueTaggerInterface;

class ContentInfoTagger implements ValueTaggerInterface
{
    public function tag(TagHandlerInterface $tagHandler, ValueObject $value)
    {
        if (!$value instanceof ContentInfo) {
            return $this;
        }

        $tagHandler->addTags(['content-' . $value->id, 'content-type-' . $value->contentTypeId]);

        if ($value->mainLocationId) {
            $tagHandler->addTags(['location-' . $value->mainLocationId]);
        }
    }
}
