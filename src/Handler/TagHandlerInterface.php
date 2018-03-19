<?php

namespace EzSystems\PlatformHttpCacheBundle\Handler;

interface TagHandlerInterface
{
    /**
     * @param array $tags
     *
     * @return $this
     */
    public function addTags(array $tags);

    /**
     * @return bool True if this handler will set at least one tag
     */
    public function hasTags();
}
