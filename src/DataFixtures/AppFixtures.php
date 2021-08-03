<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {

        $this->loadMicroPosts($manager);
        $this->loadUsers($manager);
        
    }

    private function loadMicroPosts(ObjectManager $manager)
    {
        for($i = 0; $i < 10; $i++) {
            $microPost = new MicroPost();
            $microPost->setText('Some random text ' . rand(0, 100));
            $microPost->setTime(new \DateTime('2021-07-30'));
            $manager->persist($microPost);
        }

        $manager->flush();        
    }

    private function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("test");
        $user->setFullName("Test");
        $user->setEmail("test@test.aim");
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                    $user, 
                    "test10"
                )
        );

        $manager->persist($user);
        $manager->flush();
    }
}
