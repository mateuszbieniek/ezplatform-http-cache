<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\PlatformHttpCacheBundle\EventSubscriber;

use EzSystems\PlatformHttpCacheBundle\Handler\TagHandlerInterface;
use EzSystems\PlatformHttpCacheBundle\ResponseConfigurator\ResponseCacheConfigurator;
use EzSystems\PlatformHttpCacheBundle\ResponseTagger\ViewTaggerInterface;
use eZ\Publish\Core\MVC\Symfony\View\CachableView;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Configures the Response HTTP cache properties.
 */
class HttpCacheResponseSubscriber implements EventSubscriberInterface
{
    /** @var \EzSystems\PlatformHttpCacheBundle\ResponseTagger\ViewTaggerInterface */
    private $dispatcherTagger;

    /** @var \EzSystems\PlatformHttpCacheBundle\ResponseConfigurator\ResponseCacheConfigurator */
    private $responseConfigurator;

    /** @var \EzSystems\PlatformHttpCacheBundle\Handler\TagHandlerInterface */
    private $tagHandler;


    public function __construct(
        ResponseCacheConfigurator $responseConfigurator,
        ViewTaggerInterface $dispatcherTagger,
        TagHandlerInterface $tagHandler
    ) {
        $this->responseConfigurator = $responseConfigurator;
        $this->dispatcherTagger = $dispatcherTagger;
        $this->tagHandler = $tagHandler;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => [
                ['configureCache', 5],
            ]
        ];
    }

    public function configureCache(FilterResponseEvent $event)
    {
        $view = $event->getRequest()->attributes->get('view');
        if (!$view instanceof CachableView || !$view->isCacheEnabled()) {
            return;
        }

        $response = $event->getResponse();
        $this->responseConfigurator->enableCache($response);
        $this->responseConfigurator->setSharedMaxAge($response);
        $this->dispatcherTagger->tag($this->tagHandler, $view);
        // After this FOSHTTPCache will take care about placing tags on response object headers
    }
}
