<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\MicroPost;
use App\Entity\User;
use App\Entity\UserPreferences;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private const USERS = [
        [
            'username' => 'john_doe',
            'email' => 'john_doe@doe.com',
            'password' => 'aime10',
            'fullName' => 'John Doe',
            'roles' => [User::ROLE_USER]
        ],
        [
            'username' => 'rob_smith',
            'email' => 'rob_smith@smith.com',
            'password' => 'aime10',
            'fullName' => 'Rob Smith',
            'roles' => [User::ROLE_USER]
        ],
        [
            'username' => 'marry_gold',
            'email' => 'marry_gold@gold.com',
            'password' => 'aime10',
            'fullName' => 'Marry Gold',
            'roles' => [User::ROLE_USER]
        ],
        [
            'username' => 'aime',
            'email' => 'aime@aim.com',
            'password' => 'aime10',
            'fullName' => 'Aim Aime',
            'roles' => [User::ROLE_ADMIN]
        ],
    ];

    private const POST_TEXT = [
        'Hello, how are you?',
        'It\'s nice sunny weather today',
        'I need to buy some ice cream!',
        'I wanna buy a new car',
        'There\'s a problem with my phone',
        'I need to go to the doctor',
        'What are you up to today?',
        'Did you watch the game yesterday?',
        'How was your day?'
    ];

    private const LANGUAGES = [
        'en',
        'ro'
    ];

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

        // load users and then microposts since the reference for micropost does not exist
        $this->loadUsers($manager);
        $this->loadMicroPosts($manager);
        
    }

    private function loadMicroPosts(ObjectManager $manager)
    {
        for($i = 0; $i < 30; $i++) {
            $microPost = new MicroPost();
            $microPost->setText(self::POST_TEXT[rand(0, count(self::POST_TEXT)-1)]);
            $date = new \DateTime();
            $date->modify('-' . rand(0, 10) . ' day');
            $microPost->setTime($date);

            $microPost->setUser($this->getReference(
                self::USERS[rand(0, count(self::USERS)-1)]['username']
            ));
            $manager->persist($microPost);
        }

        $manager->flush();        
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach(self::USERS as $userData)
        {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setFullName($userData['fullName']);
            $user->setEmail($userData['email']);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                        $user, 
                        $userData['password']
                    )
            );
            $user->setRoles($userData['roles']);
            $user->setEnabled(true);
    
            $this->addReference(
                $userData['username'], 
                $user
            );
    
            $preferences = new UserPreferences();
            $preferences->setLocale(self::LANGUAGES[rand(0,1)]);

            $user->setPreferences($preferences);

            //$manager->persist($preferences);

            $manager->persist($user);
        }
        
        $manager->flush();
    }
}
