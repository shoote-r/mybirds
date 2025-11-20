<?php

namespace App\DataFixtures;

use App\Entity\Aviary;
use App\Entity\Member;
use App\Entity\Garden;
use App\Entity\Birds;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    /**
     * Generates initialization data for members :
     *  [email, plain text password]
     * @return \\Generator
     */
    private function membersGenerator()
    {
        yield ['olivier@localhost','123456'];
        yield ['slash@localhost','123456'];
    }
    
    private function loadGardens(ObjectManager $manager)
    {
        $index = 1;
        foreach ($this->getGardens() as [$description, $size, $name, $memberRef]) {
            $garden = new Garden();
            $garden->setDescription($description);
            $garden->setSize($size);
            $garden->setName($name);
            
            // link GArden to the correct Member
            /** @var Member $member */
            $member = $this->getReference($memberRef, Member::class);
            $garden->setMember($member);
            $member->setGarden($garden);
            
            $manager->persist($garden);
            
            // Reference to link Birds
            $this->addReference('garden_' . $index, $garden);
            $index++;
        }
        
        $manager->flush();
    }
    
    
    private function getGardens()
    {
        // description, size, name, memberRef
        yield ['This is nice', 12, 'My first Garden', 'member_1'];
        yield [null, 43, 'My second Garden', 'member_2'];
    }
    
    
    
    private function loadBirds(ObjectManager $manager)
    {
        $index = 1;
        foreach ($this->getBirds() as [$name, $description, $gardenRef]) {
            $bird = new Birds();
            $bird->setDescription($description);
            $bird->setName($name);
            
            /** @var Garden $garden */
            $garden = $this->getReference($gardenRef, Garden::class);
            $bird->setGarden($garden);
            $manager->persist($bird);
            
            // Reference to later add then to an aviary
            $this->addReference('bird_' . $index, $bird);
            $index++;
        }
        
        $manager->flush();
    }
    
    
    private function getBirds()
    {
        yield['First Bird', 'Will ask you how was your day :)', 'garden_1'];
        yield['Second Bird', 'This bird is a hater frfr', 'garden_2'];
        
    }
    
    private function getAviaries()
    {
        // description, published, memberRef, birdsRefs[]
        yield ['Olivier public aviary', true, 'member_1', ['bird_1']];
        yield ['Slash public aviary',   true, 'member_2', ['bird_2']];
    }
    
    private function loadAviaries(ObjectManager $manager)
    {
        foreach ($this->getAviaries() as [$description, $published, $memberRef, $birdsRefs]) {
            $aviary = new Aviary();
            $aviary->setDescription($description);
            $aviary->setPublished($published);
            
            /** @var Member $member */
            $member = $this->getReference($memberRef, Member::class);
            $aviary->setMember($member);
            $member->addAviary($aviary);
            
            // Link existing birds to an Aviary (ManyToMany)
            foreach ($birdsRefs as $birdRef) {
                /** @var Birds $bird */
                $bird = $this->getReference($birdRef, Birds::class);
                $aviary->addBird($bird);
            }
            
            $manager->persist($aviary);
        }
        
        $manager->flush();
    }
    
    
    
    public function load(ObjectManager $manager): void
    {
        $index = 1;
        foreach ($this->membersGenerator() as [$email, $plainPassword]) {
            $user = new Member();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);
            
            // $roles = array();
            // $roles[] = $role;
            // $user->setRoles($roles);
            
            $manager->persist($user);
            
            // Reference for later use
            $this->addReference('member_' . $index, $user);
            $index++;
        }
        
        $this->loadGardens($manager);
        $this->loadBirds($manager);
        $this->loadAviaries($manager); 
        
        $manager->flush();
    }
    
}
