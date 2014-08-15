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

class LoadBlocksData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $session = $manager->getPhpcrSession();

        $basepath = $this->container->getParameter('cmf_block.persistence.phpcr.block_basepath');
        NodeHelper::createPath($session, $basepath);

        $parent = $manager->find(null, $basepath);
        $repository = $this->container->get('sylius.repository.block');

        $contactBlock = $repository->createNew();
        $contactBlock->setParentDocument($parent);
        $contactBlock->setName('contact');
        $contactBlock->setTitle('Контакты');
        $contactBlock->setBody('г. Санкт-Петербург,<br> Пироговская набережная, 21А,<br> БЦ "НОБЕЛЬ", офис 68<br><br> Тел.:<b> (812)715-52-53</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b> (812)715-23-23</b><br>Тел.:<b> (812)329-01-88</b>(факс)<br><br>E-mail: <a href="mailto:contact@binidini.ru">contact@binidini.ru</a>');

        $manager->persist($contactBlock);

        for ($i = 1; $i <= 3; $i++) {
            $block = $repository->createNew();
            $block->setParentDocument($parent);
            $block->setName('block-'.$i);
            $block->setTitle(ucfirst($this->faker->word));
            $block->setBody($this->faker->paragraph);

            $manager->persist($block);
        }

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
