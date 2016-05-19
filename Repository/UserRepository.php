<?php
// src/Nicolas/StatBundle/Repository/VisitRepository.php
namespace Nicolas\StatBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Nicolas\StatBundle\Entity\User;

/**
 * Class UserRepository
 * @package Nicolas\StatBundle\Entity
 */
class UserRepository extends EntityRepository
{
	/**
	 * @return array
	 */
	public function findUserOrderByLastVisit()
	{

		$qb = $this->createQueryBuilder('u');

		$qb
			->addSelect('COUNT(v.id) as totalVisit, MAX(v.dateTime) AS lastVisit')
			->innerJoin('NicolasStatBundle:Visit', 'v', 'WITH', 'u.id = v.user')
			->groupBy('u.id')
			->orderBy('lastVisit', 'DESC')
		;

		return $qb
			->getQuery()
			->getScalarResult()
			;
	}
}