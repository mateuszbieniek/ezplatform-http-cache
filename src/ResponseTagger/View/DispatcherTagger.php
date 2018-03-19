<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\PlatformHttpCacheBundle\ResponseTagger\View;

use eZ\Publish\Core\MVC\Symfony\View\View;
use EzSystems\PlatformHttpCacheBundle\Handler\TagHandlerInterface;
use EzSystems\PlatformHttpCacheBundle\ResponseTagger\ViewTaggerInterface;

/**
 * Dispatches a value to all registered View Taggers.
 */
class DispatcherTagger implements ViewTaggerInterface
{
    /**
     * @var \EzSystems\PlatformHttpCacheBundle\ResponseTagger\ViewTaggerInterface
     */
    private $taggers = [];

    public function __construct(array $taggers = [])
    {
        $this->taggers = $taggers;
    }

    public function tag(TagHandlerInterface $tagHandler, View $view)
    {
        foreach ($this->taggers as $tagger) {
            $tagger->tag($tagHandler, $view);
        }
    }
}
