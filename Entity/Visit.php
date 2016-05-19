<?php
// src/Nicolas/StatBundle/Entity/Visit.php

namespace Nicolas\StatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Nicolas\StatBundle\Repository\VisitRepository")
 * @ORM\Table(name="stat_visit")
 */
class Visit
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * User uri.
	 *
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $uri;

	/**
	 * User referer.
	 *
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $referer;

	/**
	 * User query.
	 *
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $query;

	/**
	 * @var integer
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $dateTime;

	/**
	 * @var user
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="visits")
	 */
	protected $user;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getUri()
	{
		return $this->uri;
	}

	/**
	 * @param string $uri
	 */
	public function setUri($uri)
	{
		$this->uri = $uri;
	}

	/**
	 * @return string
	 */
	public function getReferer()
	{
		return $this->referer;
	}

	/**
	 * @param string $referer
	 */
	public function setReferer($referer)
	{
		$this->referer = $referer;
	}

	/**
	 * @return string
	 */
	public function getQuery()
	{
		return $this->query;
	}

	/**
	 * @param string $query
	 */
	public function setQuery($query)
	{
		$this->query = $query;
	}

	/**
	 * @return int
	 */
	public function getDateTime()
	{
		return $this->dateTime;
	}

	/**
	 * @param int $dateTime
	 */
	public function setDateTime($dateTime)
	{
		$this->dateTime = $dateTime;
	}

	/**
	 * @return user
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param user $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}

}