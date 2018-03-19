<?php

namespace EzSystems\PlatformHttpCacheBundle\Handler;

use FOS\HttpCacheBundle\Handler\TagHandler as FOSTagHandler;
use Symfony\Component\HttpFoundation\Response;
use FOS\HttpCacheBundle\CacheManager;

/**
 * This is not a full implementation of FOS TagHandler
 * It extends extends TagHandler and implements invalidateTags() and purge() so that you may run
 * php app/console fos:httpcache:invalidate:tag <tag>.
 *
 * It implements tagResponse() to make sure TagSubscriber( a FOS event listener ) do not try to tag the response.
 * as we use ConfigurableResponseCacheConfigurator for that purpose instead.
 */
class TagHandler extends FOSTagHandler implements TagHandlerInterface
{
    private $cacheManager;
    private $purgeClient;
    protected $tagsHeader;

    public function __construct(CacheManager $cacheManager, $tagsHeader, $purgeClient)
    {
        $this->cacheManager = $cacheManager;
        $this->tagsHeader = $tagsHeader;
        $this->purgeClient = $purgeClient;
        $this->addTags(['ez-all']);
    }

    public function invalidateTags(array $tags)
    {
        $this->purge($tags);
    }

    public function purge($tags)
    {
        $this->purgeClient->purge($tags);
    }

    public function tagResponse(Response $response, $replace = false)
    {
        $tags = [];
        if (!$replace && $response->headers->has($this->tagsHeader)) {
            $headerValue = $response->headers->get($this->tagsHeader);
            if ('' !== $headerValue) {
                // compat code for possible array seperated value
                if (strpos($headerValue, ',') !== false) {
                    $tags = explode(',', $headerValue);
                } else {
                    $tags = explode(' ', $headerValue);
                }
            }
        }


        if ($this->hasTags()) {
            $tags = array_merge($tags, explode(',', $this->getTagsHeaderValue()));
        }

        if (empty($tags)) {
            $response->headers->remove($this->tagsHeader);
        } else {
            $response->headers->set($this->tagsHeader, implode(' ', array_unique($tags)));
        }


        return $this;
    }
}
