<?php
// src/Nicolas/StatBundle/Entity/User.php

namespace Nicolas\StatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Nicolas\StatBundle\Repository\UserRepository")
 * @ORM\Table(name="stat_user")
 */
class User
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var integer
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $cookie;

	/**
	 * User ip.
	 *
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $ip;

	/**
	 * @var integer
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $port;
	
	/**
	 * User userAgent.
	 *
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $userAgent;

	/**
	 * User lang.
	 *
	 * @var string
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $lang;

	/**
	 * @ORM\OneToMany(targetEntity="Visit", mappedBy="user", cascade={"remove"})
	 */
	protected $visits;

	public function __construct()
	{
		$this->visits = new \Doctrine\Common\Collections\ArrayCollection();

	}

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
	 * @return int
	 */
	public function getCookie()
	{
		return $this->cookie;
	}

	/**
	 * @param int $cookie
	 */
	public function setCookie($cookie)
	{
		$this->cookie = $cookie;
	}

	/**
	 * @return string
	 */
	public function getIp()
	{
		return $this->ip;
	}

	/**
	 * @param string $ip
	 */
	public function setIp($ip)
	{
		$this->ip = $ip;
	}

	/**
	 * @return int
	 */
	public function getPort()
	{
		return $this->port;
	}

	/**
	 * @param int $port
	 */
	public function setPort($port)
	{
		$this->port = $port;
	}

	/**
	 * @return string
	 */
	public function getUserAgent()
	{
		return $this->userAgent;
	}

	/**
	 * @param string $userAgent
	 */
	public function setUserAgent($userAgent)
	{
		$this->userAgent = $userAgent;
	}

	/**
	 * @return string
	 */
	public function getLang()
	{
		return $this->lang;
	}

	/**
	 * @param string $lang
	 */
	public function setLang($lang)
	{
		$this->lang = $lang;
	}

	/**
	 * @return mixed
	 */
	public function getVisits()
	{
		return $this->visits;
	}

	/**
	 * @param mixed $visits
	 */
	public function setVisits($visits)
	{
		$this->visits = $visits;
	}

}