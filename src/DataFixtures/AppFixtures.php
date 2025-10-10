<?php

namespace App\DataFixtures;

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
        foreach ($this->getGardens() as [$description, $size, $name]) {
            $garden = new Garden();
            $garden->setDescription($description);
            $garden->setSize($size);
            $garden->setName($name);
            $manager->persist($garden);
            
            $this->addReference('garden_'.$index, $garden);
            $index++;
        }
        $manager->flush();
    }
    
    private function getGardens()
    {
        yield['This is nice', 12, 'My first Garden'];
        yield[null, 43, 'My second Garden'];
    }
    
    
    private function loadBirds(ObjectManager $manager) 
    {
        foreach ($this->getBirds() as [$name, $description, $gardenRef]) {
            $bird = new Birds();
            $bird->setDescription($description);
            $bird->setName($name);
            $bird->setGarden($this->referenceRepository->getReference($gardenRef, Garden::class));
            $manager->persist($bird);
        }
    }
    
    private function getBirds()
    {
        yield['First Bird', 'Will ask you how was your day :)', 'garden_1'];
        yield['Second Bird', 'This bird is a hater frfr', 'garden_2'];
        
    }
    
    
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
        foreach ($this->membersGenerator() as [$email, $plainPassword]) {
            $user = new Member();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);
            
            // $roles = array();
            // $roles[] = $role;
            // $user->setRoles($roles);
            
            $manager->persist($user);
        }
        
        $this->loadGardens($manager);
        $this->loadBirds($manager);

        $manager->flush();
    }
}
