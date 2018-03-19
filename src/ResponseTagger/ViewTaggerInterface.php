<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\PlatformHttpCacheBundle\ResponseTagger;

use eZ\Publish\Core\MVC\Symfony\View\View;
use EzSystems\PlatformHttpCacheBundle\Handler\TagHandlerInterface;

/**
 * Tags a Response based on data from a view value.
 */
interface ViewTaggerInterface
{
    /**
     * @param TagHandlerInterface $tagHandler
     * @param View $view
     *
     * @return $this
     */
    public function tag(TagHandlerInterface $tagHandler, View $view);
}
