<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        // On créé ici les parents
        $parent = $this->createCategory('Informatique', null, $manager, );

        // On créé les sous-catégories
        $this->createCategory('Ordinateurs portables', $parent, $manager);
        $this->createCategory('Souris', $parent, $manager);
        $this->createCategory('Écrans', $parent, $manager);

        // On créé ici un nouveau parent
        $parent = $this->createCategory('Mode', null, $manager, );

        $this->createCategory('Hommes', $parent, $manager);
        $this->createCategory('Femmes', $parent, $manager);
        $this->createCategory('Enfants', $parent, $manager);

        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager) {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        // référence de catégorie
        $this->addReference('cat-'.$this->counter, $category);
        // Puis on incrémente le compteur
        $this->counter++;

        return $category;
    }
}
