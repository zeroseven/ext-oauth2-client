<?php

namespace Waldhacker\Oauth2Client\EventListener;

use TYPO3\CMS\Core\Http\ResponseFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\FrontendLogin\Event\BeforeRedirectEvent;
use Waldhacker\Oauth2Client\Service\SessionService;

class RedirectListener
{
    private SessionService $sessionService;

    public function __construct()
    {
        $this->sessionService = GeneralUtility::makeInstance(SessionService::class);
    }

    public function __invoke(BeforeRedirectEvent $event)
    {
        $return_url = $this->sessionService->hasDataByKey('oauth_return_url') ? $this->sessionService->getDataByKey('oauth_return_url') : '/home';
        $responseFactory = GeneralUtility::makeInstance(ResponseFactory::class);
        $response = $responseFactory->createResponse(303)->withAddedHeader('location', $return_url);

        throw new StopActionException('redirectToUri', 1476045828, null, $response);
    }
}
