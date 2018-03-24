<?php
/**
 */

namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $now = new \dateTime();
        foreach ($this->getCategoryData() as [$title]) {
            $category = new Category();
            $category->setTitle($title);
            $category->setCreationDate($now);
            $category->setUpdateDate($now);

            $manager->persist($category);
        }
        $manager->flush();
    }

    private function getCategoryData()
    {
        return [
            ['Conseils parcours OC'], ['Outils'],['Pour s\'entraîner'], ['Php'], ['Javascript'],
            ['Python'], ['Java'], ['Swift'], ['Go'], ['Autres languages'], ['Docker'], ['Electronique'],
            ['Méthhode de travail'], ['Livres, ebook'], ['Suggestions'],
        ];
    }
}
