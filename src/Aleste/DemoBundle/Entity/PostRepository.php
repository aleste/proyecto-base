<?php

namespace Aleste\DemoBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{

	public function queryGetPosts(){

		$em = $this->getEntityManager();
		$query = $em->createQuery(
		    'SELECT p
		     FROM AlesteDemoBundle:Post p'
		);

		return $query;
	}

	public function getPosts(){
		return $this->queryGetPosts()->getResult();
	}
	
}