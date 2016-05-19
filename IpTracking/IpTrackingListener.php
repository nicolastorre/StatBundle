<?php
// src/Nicolas/DeployBundle/IpTracking/IpTrackingListener.php
namespace Nicolas\StatBundle\IpTracking;

use Nicolas\StatBundle\IpTracking\IpTrackingManager;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;


class IpTrackingListener
{
	/**
	 * @var IpTrackingManager
	 */
	protected $ipTrackingManager;

	public function __construct(IpTrackingManager $ipTrackingManager) {

		$this->ipTrackingManager = $ipTrackingManager;
	}

	public function run(FilterResponseEvent $event) {
		$this->ipTrackingManager->addVisit($event);
	}
}