<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\PlatformHttpCacheBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Processes services tagged as ezplatform.view_cache.view_tagger and ezplatform.view_cache.value_tagger, and registers
 * them with a corresponding dispatcher service.
 */
class ResponseTaggersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $this->registerTaggers($container, 'view_tagger');
        $this->registerTaggers($container, 'value_tagger');
    }

    private function registerTaggers(ContainerBuilder $container, $taggerId)
    {
        if (!$container->hasDefinition("ezplatform.view_cache.${taggerId}.dispatcher")) {
            return;
        }

        $taggers = [];
        $taggedServiceIds = $container->findTaggedServiceIds("ezplatform.view_cache.${taggerId}");
        foreach ($taggedServiceIds as $taggedServiceId => $tags) {
            $taggers[] = new Reference($taggedServiceId);
        }

        $dispatcher = $container->getDefinition("ezplatform.view_cache.${taggerId}.dispatcher");
        $dispatcher->replaceArgument(0, $taggers);
    }
}
