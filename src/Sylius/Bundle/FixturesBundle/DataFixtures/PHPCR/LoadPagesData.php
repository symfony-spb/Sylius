<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FixturesBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use PHPCR\Util\NodeHelper;
use Sylius\Bundle\FixturesBundle\DataFixtures\DataFixture;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class LoadPagesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $session = $manager->getPhpcrSession();

        $basepath = $this->container->getParameter('cmf_routing.dynamic.persistence.phpcr.route_basepath');
        NodeHelper::createPath($session, $basepath);

        $routeRoot = $manager->find(null, $basepath);

        $basepath = $this->container->getParameter('cmf_content.persistence.phpcr.content_basepath');
        NodeHelper::createPath($session, $basepath);

        $parent = $manager->find(null, $basepath);
        $repository = $this->container->get('sylius.repository.page');

        // Return Policy
        $route = new Route();
        $route->setPosition($routeRoot, 'return-policy');
        $manager->persist($route);

        $content = $repository->createNew();
        $content->setTitle('Правила возврата');
        $content->setBody($this->faker->text(500));
        $content->addRoute($route);
        $content->setParent($parent);
        $content->setName('return-policy');

        $manager->persist($content);

        // Discounts
        $route = new Route();
        $route->setPosition($routeRoot, 'discounts');
        $manager->persist($route);

        $content = $repository->createNew();
        $content->setTitle('Наши скидки');
        $content->setBody($this->faker->text(500));
        $content->addRoute($route);
        $content->setParent($parent);
        $content->setName('dicsounts');

        $manager->persist($content);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
