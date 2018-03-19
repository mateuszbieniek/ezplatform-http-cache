<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\PlatformHttpCacheBundle\ResponseTagger\View;

use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\Core\MVC\Symfony\View\LocationValueView;
use eZ\Publish\Core\MVC\Symfony\View\View;
use EzSystems\PlatformHttpCacheBundle\Handler\TagHandlerInterface;
use EzSystems\PlatformHttpCacheBundle\ResponseTagger\ViewTaggerInterface;
use EzSystems\PlatformHttpCacheBundle\ResponseTagger\ValueTaggerInterface;

class LocationValueViewTagger implements ViewTaggerInterface
{
    /**
     * @var \EzSystems\PlatformHttpCacheBundle\ResponseTagger\ValueTaggerInterface
     */
    private $locationTagger;

    public function __construct(ValueTaggerInterface $locationTagger)
    {
        $this->locationTagger = $locationTagger;
    }

    public function tag(TagHandlerInterface $tagHandler, View $view)
    {
        if (!$view instanceof LocationValueView || !($location = $view->getLocation()) instanceof Location) {
            return $this;
        }

        $this->locationTagger->tag($tagHandler, $location);

        return $this;
    }
}
