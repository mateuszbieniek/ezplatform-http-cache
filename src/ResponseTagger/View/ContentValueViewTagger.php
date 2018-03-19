<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\PlatformHttpCacheBundle\ResponseTagger\View;

use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\Core\MVC\Symfony\View\ContentValueView;
use eZ\Publish\Core\MVC\Symfony\View\View;
use EzSystems\PlatformHttpCacheBundle\Handler\TagHandlerInterface;
use EzSystems\PlatformHttpCacheBundle\ResponseTagger\ViewTaggerInterface;
use EzSystems\PlatformHttpCacheBundle\ResponseTagger\ValueTaggerInterface;

class ContentValueViewTagger implements ViewTaggerInterface
{
    /**
     * @var \EzSystems\PlatformHttpCacheBundle\ResponseTagger\ValueTaggerInterface
     */
    private $contentInfoTagger;

    public function __construct(ValueTaggerInterface $contentInfoTagger)
    {
        $this->contentInfoTagger = $contentInfoTagger;
    }

    public function tag(TagHandlerInterface $tagHandler, View $view)
    {
        if (!$view instanceof ContentValueView || !($content = $view->getContent()) instanceof Content) {
            return $this;
        }

        $contentInfo = $content->getVersionInfo()->getContentInfo();
        $this->contentInfoTagger->tag($tagHandler, $contentInfo);

        return $this;
    }
}
