<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Entity\Comment;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\VarDumper\Cloner\Data;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;


class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName('sport');
        $manager->persist($category);
        $manager->flush();

        $category = new Category();
        $category->setName('history');
        $manager->persist($category);
        $manager->flush();

        $category = new Category();
        $category->setName('society');
        $manager->persist($category);
        $manager->flush();

        $category = new Category();
        $category->setName('psychology');
        $manager->persist($category);
        $manager->flush();

        $category = new Category();
        $category->setName('economics');
        $manager->persist($category);
        $manager->flush();

        $category = new Category();
        $category->setName('politics');
        $manager->persist($category);
        $manager->flush();




         //add roles

             $role1 = new Role();
             $role1->setName('author');
             $manager->persist($role1);
             $manager->flush();

             $role2 = new Role();
             $role2->setName('commentator');
             $manager->persist($role2);

             $manager->flush();


        //add user
             $user = new User();
             $user->setFirstName('kola');
             $user->setLastName('kolakov');
             $user->setLogin('loginloginlgin');
             $user->setPassword('dsddd');
             $user->setCity('cherkassy');
             $user->setAddress('bulvar 53');
             $user->setEmail('mail@fdd');
             $user->setEnabled('true');

         $roleId = $manager->getRepository('AppBundle:Role')->find('1');

        $user->setRole($roleId);
             $user->setRating('10');
             $user->setDataCreate('2016-11-11');
             $manager->persist($user);
             $manager->flush();

        $user = new User();
        $user->setFirstName('petro');
        $user->setLastName('petrov');
        $user->setLogin('loginnewloffggfg');
        $user->setPassword('dsddd');
        $user->setCity('cherkassy');
        $user->setAddress('bulvar 53');
        $user->setEmail('mail@fdd');
        $user->setEnabled('true');
        $roleId = $manager->getRepository('AppBundle:Role')->find('1');
        $user->setRole($roleId);
        $user->setRating('10');
        $user->setDataCreate('2016-11-11');
        $manager->persist($user);
        $manager->flush();


        $post = new Post();
        $post->setName('fgffg');
        $post->setDescription('Foster, treatment pursue these aspirations nonprofit; equity initiative disruptor');
        $authorId = $manager->getRepository('AppBundle:User')->find('1');
        $post->addAuthor($authorId);
        $authorId = $manager->getRepository('AppBundle:User')->find('2');
        $post->addAuthor($authorId);
        $post->setBody('Peaceful plumpy\'nut strengthen democracy, Aga Khan breakthrough insights. Innovation Medecins du Monde, micro-finance collaborative consumption think tank. Effectiveness resourceful public institutions solutions inspire breakthroughs; Ford Foundation democratizing the global financial system approach meaningful work. Economic development; lifting people up crisis management community diversity economic security. NGO raise awareness change movements; social, developing nations humanitarian relief challenges initiative courageous. Mobilize dignity, billionaire philanthropy nonviolent resistance Angelina Jolie accelerate progress. Combat malaria best practices cornerstone effect working families experience in the field legitimize dedicated. Liberal; overcome injustice safeguards hack, civil society celebrate. Deep engagement future humanitarian transform gun control theory of social change Jane Addams amplify nonprofit. Enable, results safety proper resources positive social change education human potential assessment expert. Jane Jacobs fighting poverty vaccines affiliate progressive. Improving quality fellows aid; gender equality social innovation maximize shifting landscape. Tackling human rights, beneficiaries equity board of directors. Assistance developing medical supplies worldwide, thinkers who make change happen tackle open source. Respond non-partisan disruptor momentum involvement pathway to a better life. Natural resources contribution local; research health. Frontline; insurmountable challenges; technology political, Rosa Parks Bloomberg underprivileged conflict resolution. United Nations pride social impact shift socio-economic divide. Kickstarter, action catalyst equal opportunity donate international development disruption minority. Eradicate, collaborative; cross-cultural medical organization; necessities working alongside human-centered design Cesar Chavez. Social good altruism evolution change lives youth educate. Impact; free expression; efficient, new approaches, partner, agriculture making progress affordable health care treatment. Medicine, global leaders, world problem solving gender freedom foster stakeholders. Advancement opportunity, advocate refugee; honor, public sector, human experience cooperation. Rural development social responsibility process smart cities, expanding community ownership accessibility informal economies prevention. Globalization, implementation poverty, citizenry provide solve, combat HIV/AIDS social analysis. Replicable Millennium Development Goals policy dialogue, volunteer public service truth development carbon emissions reductions. Sanitation Global South Bill and Melinda Gates sustainable transform the world free-speech elevate transformative global. Accelerate; reproductive rights, innovate network clean water visionary crisis situation.');
        $categoryId = $manager->getRepository('AppBundle:Category')->find('1');
        $post->setCategory($categoryId);
        $post->setEnabled('true');
        $post->setHashtag('dd');
        $post->setRating('5');
        $post->setDataCreate('2016-12-01');
        $post->setDataEdit('2016-12-03');
        $manager->persist($post);
        $manager->flush();

        $post = new Post();
        $post->setName('kjkjkjk');
        $post->setDescription('Foster, treatment pursue these aspirations nonprofit; equity initiative disruptor');
        $authorId = $manager->getRepository('AppBundle:User')->find('1');
        $post->addAuthor($authorId);
        $post->setBody('Peaceful plumpy\'nut strengthen democracy, Aga Khan breakthrough insights. Innovation Medecins du Monde, micro-finance collaborative consumption think tank. Effectiveness resourceful public institutions solutions inspire breakthroughs; Ford Foundation democratizing the global financial system approach meaningful work. Economic development; lifting people up crisis management community diversity economic security. NGO raise awareness change movements; social, developing nations humanitarian relief challenges initiative courageous. Mobilize dignity, billionaire philanthropy nonviolent resistance Angelina Jolie accelerate progress. Combat malaria best practices cornerstone effect working families experience in the field legitimize dedicated. Liberal; overcome injustice safeguards hack, civil society celebrate. Deep engagement future humanitarian transform gun control theory of social change Jane Addams amplify nonprofit. Enable, results safety proper resources positive social change education human potential assessment expert. Jane Jacobs fighting poverty vaccines affiliate progressive. Improving quality fellows aid; gender equality social innovation maximize shifting landscape. Tackling human rights, beneficiaries equity board of directors. Assistance developing medical supplies worldwide, thinkers who make change happen tackle open source. Respond non-partisan disruptor momentum involvement pathway to a better life. Natural resources contribution local; research health. Frontline; insurmountable challenges; technology political, Rosa Parks Bloomberg underprivileged conflict resolution. United Nations pride social impact shift socio-economic divide. Kickstarter, action catalyst equal opportunity donate international development disruption minority. Eradicate, collaborative; cross-cultural medical organization; necessities working alongside human-centered design Cesar Chavez. Social good altruism evolution change lives youth educate. Impact; free expression; efficient, new approaches, partner, agriculture making progress affordable health care treatment. Medicine, global leaders, world problem solving gender freedom foster stakeholders. Advancement opportunity, advocate refugee; honor, public sector, human experience cooperation. Rural development social responsibility process smart cities, expanding community ownership accessibility informal economies prevention. Globalization, implementation poverty, citizenry provide solve, combat HIV/AIDS social analysis. Replicable Millennium Development Goals policy dialogue, volunteer public service truth development carbon emissions reductions. Sanitation Global South Bill and Melinda Gates sustainable transform the world free-speech elevate transformative global. Accelerate; reproductive rights, innovate network clean water visionary crisis situation.');
        $categoryId = $manager->getRepository('AppBundle:Category')->find('2');
        $post->setCategory($categoryId);
        $post->setEnabled('true');
        $post->setHashtag('dd');
        $post->setRating('5');
        $post->setDataCreate('2016-12-01');
        $post->setDataEdit('2016-12-03');
        $manager->persist($post);
        $manager->flush();

        $post = new Post();
        $post->setName('fgffg');
        $post->setDescription('Foster, treatment pursue these aspirations nonprofit; equity initiative disruptor');
        $authorId = $manager->getRepository('AppBundle:User')->find('1');
        $post->addAuthor($authorId);
        $post->setBody('Peaceful plumpy\'nut strengthen democracy, Aga Khan breakthrough insights. Innovation Medecins du Monde, micro-finance collaborative consumption think tank. Effectiveness resourceful public institutions solutions inspire breakthroughs; Ford Foundation democratizing the global financial system approach meaningful work. Economic development; lifting people up crisis management community diversity economic security. NGO raise awareness change movements; social, developing nations humanitarian relief challenges initiative courageous. Mobilize dignity, billionaire philanthropy nonviolent resistance Angelina Jolie accelerate progress. Combat malaria best practices cornerstone effect working families experience in the field legitimize dedicated. Liberal; overcome injustice safeguards hack, civil society celebrate. Deep engagement future humanitarian transform gun control theory of social change Jane Addams amplify nonprofit. Enable, results safety proper resources positive social change education human potential assessment expert. Jane Jacobs fighting poverty vaccines affiliate progressive. Improving quality fellows aid; gender equality social innovation maximize shifting landscape. Tackling human rights, beneficiaries equity board of directors. Assistance developing medical supplies worldwide, thinkers who make change happen tackle open source. Respond non-partisan disruptor momentum involvement pathway to a better life. Natural resources contribution local; research health. Frontline; insurmountable challenges; technology political, Rosa Parks Bloomberg underprivileged conflict resolution. United Nations pride social impact shift socio-economic divide. Kickstarter, action catalyst equal opportunity donate international development disruption minority. Eradicate, collaborative; cross-cultural medical organization; necessities working alongside human-centered design Cesar Chavez. Social good altruism evolution change lives youth educate. Impact; free expression; efficient, new approaches, partner, agriculture making progress affordable health care treatment. Medicine, global leaders, world problem solving gender freedom foster stakeholders. Advancement opportunity, advocate refugee; honor, public sector, human experience cooperation. Rural development social responsibility process smart cities, expanding community ownership accessibility informal economies prevention. Globalization, implementation poverty, citizenry provide solve, combat HIV/AIDS social analysis. Replicable Millennium Development Goals policy dialogue, volunteer public service truth development carbon emissions reductions. Sanitation Global South Bill and Melinda Gates sustainable transform the world free-speech elevate transformative global. Accelerate; reproductive rights, innovate network clean water visionary crisis situation.');
        $categoryId = $manager->getRepository('AppBundle:Category')->find('3');
        $post->setCategory($categoryId);
        $post->setEnabled('true');
        $post->setHashtag('dd');
        $post->setRating('20');
        $post->setDataCreate('2016-12-01');
        $post->setDataEdit('2016-12-03');
        $manager->persist($post);
        $manager->flush();

        $post = new Post();
        $post->setName('jkjkjkjk');
        $post->setDescription('fkdkffkdfkdfd;f;fk nonprofit; equity initiative disruptor');
        $authorId = $manager->getRepository('AppBundle:User')->find('1');
        $post->addAuthor($authorId);
        $post->setBody('Peaceful plumpy\'nut strengthen democracy, Aga Khan breakthrough insights. Innovation Medecins du Monde, micro-finance collaborative consumption think tank. Effectiveness resourceful public institutions solutions inspire breakthroughs; Ford Foundation democratizing the global financial system approach meaningful work. Economic development; lifting people up crisis management community diversity economic security. NGO raise awareness change movements; social, developing nations humanitarian relief challenges initiative courageous. Mobilize dignity, billionaire philanthropy nonviolent resistance Angelina Jolie accelerate progress. Combat malaria best practices cornerstone effect working families experience in the field legitimize dedicated. Liberal; overcome injustice safeguards hack, civil society celebrate. Deep engagement future humanitarian transform gun control theory of social change Jane Addams amplify nonprofit. Enable, results safety proper resources positive social change education human potential assessment expert. Jane Jacobs fighting poverty vaccines affiliate progressive. Improving quality fellows aid; gender equality social innovation maximize shifting landscape. Tackling human rights, beneficiaries equity board of directors. Assistance developing medical supplies worldwide, thinkers who make change happen tackle open source. Respond non-partisan disruptor momentum involvement pathway to a better life. Natural resources contribution local; research health. Frontline; insurmountable challenges; technology political, Rosa Parks Bloomberg underprivileged conflict resolution. United Nations pride social impact shift socio-economic divide. Kickstarter, action catalyst equal opportunity donate international development disruption minority. Eradicate, collaborative; cross-cultural medical organization; necessities working alongside human-centered design Cesar Chavez. Social good altruism evolution change lives youth educate. Impact; free expression; efficient, new approaches, partner, agriculture making progress affordable health care treatment. Medicine, global leaders, world problem solving gender freedom foster stakeholders. Advancement opportunity, advocate refugee; honor, public sector, human experience cooperation. Rural development social responsibility process smart cities, expanding community ownership accessibility informal economies prevention. Globalization, implementation poverty, citizenry provide solve, combat HIV/AIDS social analysis. Replicable Millennium Development Goals policy dialogue, volunteer public service truth development carbon emissions reductions. Sanitation Global South Bill and Melinda Gates sustainable transform the world free-speech elevate transformative global. Accelerate; reproductive rights, innovate network clean water visionary crisis situation.');
        $categoryId = $manager->getRepository('AppBundle:Category')->find('2');
        $post->setCategory($categoryId);
        $post->setEnabled('true');
        $post->setHashtag('dd');
        $post->setRating('20');
        $post->setDataCreate('2016-12-01');
        $post->setDataEdit('2016-12-03');
        $manager->persist($post);
        $manager->flush();

        $post = new Post();
        $post->setName('334344ddsdsdsdsdg');
        $post->setDescription('fkdkffkdfkdfd;f;fk nonprofit; equity initiative disruptor');
        $authorId = $manager->getRepository('AppBundle:User')->find('1');
        $post->addAuthor($authorId);
        $post->setBody('Peaceful plumpy\'nut strengthen democracy, Aga Khan breakthrough insights. Innovation Medecins du Monde, micro-finance collaborative consumption think tank. Effectiveness resourceful public institutions solutions inspire breakthroughs; Ford Foundation democratizing the global financial system approach meaningful work. Economic development; lifting people up crisis management community diversity economic security. NGO raise awareness change movements; social, developing nations humanitarian relief challenges initiative courageous. Mobilize dignity, billionaire philanthropy nonviolent resistance Angelina Jolie accelerate progress. Combat malaria best practices cornerstone effect working families experience in the field legitimize dedicated. Liberal; overcome injustice safeguards hack, civil society celebrate. Deep engagement future humanitarian transform gun control theory of social change Jane Addams amplify nonprofit. Enable, results safety proper resources positive social change education human potential assessment expert. Jane Jacobs fighting poverty vaccines affiliate progressive. Improving quality fellows aid; gender equality social innovation maximize shifting landscape. Tackling human rights, beneficiaries equity board of directors. Assistance developing medical supplies worldwide, thinkers who make change happen tackle open source. Respond non-partisan disruptor momentum involvement pathway to a better life. Natural resources contribution local; research health. Frontline; insurmountable challenges; technology political, Rosa Parks Bloomberg underprivileged conflict resolution. United Nations pride social impact shift socio-economic divide. Kickstarter, action catalyst equal opportunity donate international development disruption minority. Eradicate, collaborative; cross-cultural medical organization; necessities working alongside human-centered design Cesar Chavez. Social good altruism evolution change lives youth educate. Impact; free expression; efficient, new approaches, partner, agriculture making progress affordable health care treatment. Medicine, global leaders, world problem solving gender freedom foster stakeholders. Advancement opportunity, advocate refugee; honor, public sector, human experience cooperation. Rural development social responsibility process smart cities, expanding community ownership accessibility informal economies prevention. Globalization, implementation poverty, citizenry provide solve, combat HIV/AIDS social analysis. Replicable Millennium Development Goals policy dialogue, volunteer public service truth development carbon emissions reductions. Sanitation Global South Bill and Melinda Gates sustainable transform the world free-speech elevate transformative global. Accelerate; reproductive rights, innovate network clean water visionary crisis situation.');
        $categoryId = $manager->getRepository('AppBundle:Category')->find('2');
        $post->setCategory($categoryId);
        $post->setEnabled('true');
        $post->setHashtag('dd');
        $post->setRating('20');
        $post->setDataCreate('2016-12-01');
        $post->setDataEdit('2016-12-03');
        $manager->persist($post);
        $manager->flush();

        $post = new Post();
        $post->setName('oooooofffgggg');
        $post->setDescription('fkdkffkdfkdfd;f;fk nonprofit; equity initiative disruptor');
        $authorId = $manager->getRepository('AppBundle:User')->find('1');
        $post->addAuthor($authorId);
        $post->setBody('Peaceful plumpy\'nut strengthen democracy, Aga Khan breakthrough insights. Innovation Medecins du Monde, micro-finance collaborative consumption think tank. Effectiveness resourceful public institutions solutions inspire breakthroughs; Ford Foundation democratizing the global financial system approach meaningful work. Economic development; lifting people up crisis management community diversity economic security. NGO raise awareness change movements; social, developing nations humanitarian relief challenges initiative courageous. Mobilize dignity, billionaire philanthropy nonviolent resistance Angelina Jolie accelerate progress. Combat malaria best practices cornerstone effect working families experience in the field legitimize dedicated. Liberal; overcome injustice safeguards hack, civil society celebrate. Deep engagement future humanitarian transform gun control theory of social change Jane Addams amplify nonprofit. Enable, results safety proper resources positive social change education human potential assessment expert. Jane Jacobs fighting poverty vaccines affiliate progressive. Improving quality fellows aid; gender equality social innovation maximize shifting landscape. Tackling human rights, beneficiaries equity board of directors. Assistance developing medical supplies worldwide, thinkers who make change happen tackle open source. Respond non-partisan disruptor momentum involvement pathway to a better life. Natural resources contribution local; research health. Frontline; insurmountable challenges; technology political, Rosa Parks Bloomberg underprivileged conflict resolution. United Nations pride social impact shift socio-economic divide. Kickstarter, action catalyst equal opportunity donate international development disruption minority. Eradicate, collaborative; cross-cultural medical organization; necessities working alongside human-centered design Cesar Chavez. Social good altruism evolution change lives youth educate. Impact; free expression; efficient, new approaches, partner, agriculture making progress affordable health care treatment. Medicine, global leaders, world problem solving gender freedom foster stakeholders. Advancement opportunity, advocate refugee; honor, public sector, human experience cooperation. Rural development social responsibility process smart cities, expanding community ownership accessibility informal economies prevention. Globalization, implementation poverty, citizenry provide solve, combat HIV/AIDS social analysis. Replicable Millennium Development Goals policy dialogue, volunteer public service truth development carbon emissions reductions. Sanitation Global South Bill and Melinda Gates sustainable transform the world free-speech elevate transformative global. Accelerate; reproductive rights, innovate network clean water visionary crisis situation.');
        $categoryId = $manager->getRepository('AppBundle:Category')->find('2');
        $post->setCategory($categoryId);
        $post->setEnabled('true');
        $post->setHashtag('dd');
        $post->setRating('20');
        $post->setDataCreate('2016-12-01');
        $post->setDataEdit('2016-12-03');
        $manager->persist($post);
        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}
