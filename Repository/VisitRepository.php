<?php
// src/Nicolas/StatBundle/Repository/VisitRepository.php
namespace Nicolas\StatBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Nicolas\StatBundle\Entity\Visit;

/**
 * Class VisitRepository
 * @package Nicolas\StatBundle\Entity
 */
class VisitRepository extends EntityRepository
{
	/**
	 * @return array
	 */
	public function findUserVisit($id)
	{

		$qb = $this->createQueryBuilder('v');

		$qb
			->select('v.id,v.uri,v.referer,v.query,v.dateTime,count(v.id) as total')
			->where('v.user = :id')
			->setParameter('id', $id)
			->groupBy('v.uri')
			->orderBy('v.dateTime', 'DESC')
		;

		return $qb
			->getQuery()
			->getResult()
		;
	}
}