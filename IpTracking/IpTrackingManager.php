<?php
// src/Nicolas/DeployBundle/IpTracking/IpTrackingManager.php
namespace Nicolas\StatBundle\IpTracking;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Cookie;
use Nicolas\StatBundle\Entity\User;
use Nicolas\StatBundle\Entity\Visit;


/**
 * Class IpTrackingManager
 * @package Nicolas\StatBundle\IpTracking
 */
class IpTrackingManager
{

	/**
	 * @var EntityManager
	 */
	protected $em;

	/**
	 * @var AuthorizationCheckerInterface
	 */
	protected $authorizationChecker;


	public function __construct(EntityManager $em, TokenStorage $tokenStorage, AuthorizationCheckerInterface $authorizationChecker) {

		$this->em = $em;
		$this->tokenStorage = $tokenStorage;
		$this->authorizationChecker = $authorizationChecker;

	}

	public function addVisit(FilterResponseEvent $event) {

		if (!is_null($this->tokenStorage->getToken()) && $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
			return false;
		}

		if (!$event->isMasterRequest()) {
			// don't do anything if it's not the master request
			return false;
		}

		$request = $event->getRequest();
		$response = $event->getResponse();

		$userRepository = $this->em->getRepository('NicolasStatBundle:User');

		$ip = $request->getClientIp();

		if($request->get('ntorre_portfolio_stat')) {
			$user = $userRepository->findOneByCookie($request->get('ntorre_portfolio_stat'));
			if($ip != $user->getIp()) {
				$user->setIp($ip);
				$user->setPort($request->getPort());
				$user->setUserAgent($request->server->get('HTTP_USER_AGENT'));
				$user->setLang($request->getPreferredLanguage());
			}
		} else {
			$cookieID = uniqid();
			$now = new \DateTime();
			$time = $now->add(new \DateInterval('P1Y'))->getTimeStamp();
			$cookie = new Cookie('ntorre_portfolio_stat', $cookieID, $time, '/');
			$response->headers->setCookie($cookie);

			$userResult = $userRepository->findByIp($ip);

			if(count($userResult) == 1) {
				$user = current($userResult);
				$user->setCookie($cookieID);

			} else {
				$user = new User();
				$user->setCookie($cookieID); // TMP
				$user->setIp($ip);
				$user->setPort($request->getPort());
				$user->setUserAgent($request->server->get('HTTP_USER_AGENT'));
				$user->setLang($request->getPreferredLanguage());

				$this->em->persist($user);
			}
		}

		$visit = new Visit();
		$visit->setUser($user);
		$visit->setUri($request->getUri());
		$visit->setReferer($request->headers->get('referer'));
		$visit->setQuery($request->getQueryString());
		$visit->setDatetime(time());

		$this->em->persist($visit);
		$this->em->flush();

		return true;
	}

}