<?php

namespace Nicolas\StatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GeoIp2\Database\Reader;

/**
 * Class StatController
 * @package Nicolas\StatBundle\Controller
 */
class StatController extends Controller
{
	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('NicolasStatBundle:User');
        $result = $userRepository->findUserOrderByLastVisit();

		$geoip_database_path = $this->container->getParameter('nicolas_stat.geoip_database_path');
		$reader = new Reader($geoip_database_path);

		$stat = array();
		foreach($result as $user) {
			if(!strpos($user['u_userAgent'], 'bot') && !strpos($user['u_userAgent'], 'spider') && !strpos($user['u_userAgent'], 'crawler')) {
				$coords = array('lat' => null, 'lng' => null);
				$city = null;
				try {
					$record = $reader->city($user['u_ip']);
					$coords = array('lat' => $record->location->latitude, 'lng' => $record->location->longitude);
					$city = $record->city->name;
				} catch (\Exception $e) {

				}

				$stat[] = array(
					'id' => $user['u_id'],
					'ip' => $user['u_ip'],
					'user_agent' => $user['u_userAgent'],
					'coords' => $coords,
					'city' => $city,
					'total_visit' => $user['totalVisit'],
					'last_visit' => $user['lastVisit']
				);
			}
		}

        return $this->render('NicolasStatBundle:Stat:index.html.twig', array(
            'stat' =>  $stat,
            'json_stat' =>  json_encode($stat)
        ));
    }

	/**
	 *
	 */
	public function detailsAction($id) {
		$em = $this->getDoctrine()->getManager();
		$userRepository = $em->getRepository('NicolasStatBundle:User');
		$visitRepository = $em->getRepository('NicolasStatBundle:Visit');

		$user = $userRepository->findOneById($id);
		$visit = $visitRepository->findUserVisit($id);

		return $this->render('NicolasStatBundle:Stat:Details.html.twig', array(
			'user' => $user,
			'visit' => $visit
		));

	}
}
