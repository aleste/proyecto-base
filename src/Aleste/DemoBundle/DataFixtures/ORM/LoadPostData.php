<?php

namespace Aleste\DemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aleste\DemoBundle\Entity\Post;

class LoadPostData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        

        for ($i=1; $i < 101; $i++) { 
            $post = new Post();
            $post->setTitle('Post '.$i);
            $post->setDescription('Post de prueba '.$i);

            $manager->persist($post);
            
        }

        $manager->flush();
        
    }
}