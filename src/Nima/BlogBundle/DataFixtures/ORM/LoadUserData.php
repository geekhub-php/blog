<?php

namespace Nima\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nima\BlogBundle\Entity\Categories;
use Nima\BlogBundle\Entity\Users;
use Nima\BlogBundle\Entity\Roles;
use Nima\BlogBundle\Entity\Posts;
use Nima\BlogBundle\Entity\Comments;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\VarDumper\Cloner\Data;


class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    { /*
        $category = new Categories();
        $category->setName('sport');
        $manager->persist($category);
        $manager->flush();

        $category = new Categories();
        $category->setName('history');
        $manager->persist($category);
        $manager->flush();

        $category = new Categories();
        $category->setName('society');
        $manager->persist($category);
        $manager->flush();

        $category = new Categories();
        $category->setName('psychology');
        $manager->persist($category);
        $manager->flush();

        $category = new Categories();
        $category->setName('economics');
        $manager->persist($category);
        $manager->flush();

        $category = new Categories();
        $category->setName('politics');
        $manager->persist($category);
        $manager->flush();




         //add roles

             $role = new Roles();
             $role->setName('author');
             $manager->persist($role);
             $manager->flush();

             $role = new Roles();
             $role->setName('commentator');
             $manager->persist($role);
             $manager->flush();
*/

/*

                //add users
                $user = new Users();
                $user->setFirstName('vas');
                $user->setLastName('vasikov');
                $user->setLogin('vaslog');
                $user->setPassword('dsddd');
                $user->setAdress('cherkassy.ffdfd');
                $user->setEmail('mail@fdd');
                $user->setEnabled('true');
                $roleId = $this->getDoctrine()
                    ->getRepository('NimaBlogBundle:Roles')
                    ->find('3');
                if (!$roleId) {
                    throw $this->createNotFoundException(
                        'No roles id'
                    );
                }

                $user->setRole($roleId);
                $user->setRating('10');
                $user->setDataCreate('2016-11-11');


                $em = $this->getDoctrine()->getManager();

                // tells Doctrine you want to (eventually) save the Product (no queries yet)
                $em->persist($user);

                // actually executes the queries (i.e. the INSERT query)
                $em->flush();

*/


        /*

        //add posts
                $post = new Posts();
                $post->setName('fgffg');
                $post->setDescription('Foster, treatment pursue these aspirations nonprofit; equity initiative disruptor');


                $authorId = $this->getDoctrine()
                    ->getRepository('NimaBlogBundle:Users')
                    ->find('1');
                if (!$authorId) {
                    throw $this->createNotFoundException(
                        'No author id'
                    );
                }
                $post->addAuthor($authorId);
                $post->setBody('Peaceful plumpy\'nut strengthen democracy, Aga Khan breakthrough insights. Innovation Medecins du Monde, micro-finance collaborative consumption think tank. Effectiveness resourceful public institutions solutions inspire breakthroughs; Ford Foundation democratizing the global financial system approach meaningful work. Economic development; lifting people up crisis management community diversity economic security. NGO raise awareness change movements; social, developing nations humanitarian relief challenges initiative courageous. Mobilize dignity, billionaire philanthropy nonviolent resistance Angelina Jolie accelerate progress. Combat malaria best practices cornerstone effect working families experience in the field legitimize dedicated. Liberal; overcome injustice safeguards hack, civil society celebrate. Deep engagement future humanitarian transform gun control theory of social change Jane Addams amplify nonprofit. Enable, results safety proper resources positive social change education human potential assessment expert. Jane Jacobs fighting poverty vaccines affiliate progressive. Improving quality fellows aid; gender equality social innovation maximize shifting landscape. Tackling human rights, beneficiaries equity board of directors. Assistance developing medical supplies worldwide, thinkers who make change happen tackle open source. Respond non-partisan disruptor momentum involvement pathway to a better life. Natural resources contribution local; research health. Frontline; insurmountable challenges; technology political, Rosa Parks Bloomberg underprivileged conflict resolution. United Nations pride social impact shift socio-economic divide. Kickstarter, action catalyst equal opportunity donate international development disruption minority. Eradicate, collaborative; cross-cultural medical organization; necessities working alongside human-centered design Cesar Chavez. Social good altruism evolution change lives youth educate. Impact; free expression; efficient, new approaches, partner, agriculture making progress affordable health care treatment. Medicine, global leaders, world problem solving gender freedom foster stakeholders. Advancement opportunity, advocate refugee; honor, public sector, human experience cooperation. Rural development social responsibility process smart cities, expanding community ownership accessibility informal economies prevention. Globalization, implementation poverty, citizenry provide solve, combat HIV/AIDS social analysis. Replicable Millennium Development Goals policy dialogue, volunteer public service truth development carbon emissions reductions. Sanitation Global South Bill and Melinda Gates sustainable transform the world free-speech elevate transformative global. Accelerate; reproductive rights, innovate network clean water visionary crisis situation.');

                $categoryId = $this->getDoctrine()
                    ->getRepository('NimaBlogBundle:Categories')
                    ->find('4');
                    if (!$categoryId) {
                        throw $this->createNotFoundException(
                            'No category id'
                        );
                    }
                $post->setCategory($categoryId);
                $post->setEnabled('true');
                $post->setHashtag('dd');
                $post->setRating('5');
                $post->setDataCreate('2016-12-01');
                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();

                 $post = new Posts();
                 $post->setName('kjkjkjkjkj');
                 $post->setDescription('Foster, treatment pursue these aspirations nonprofit; equity initiative disruptor');


                        $authorId = $this->getDoctrine()
                            ->getRepository('NimaBlogBundle:Users')
                            ->find('1');
                        if (!$authorId) {
                            throw $this->createNotFoundException(
                                'No author id'
                            );
                        }
                            $post->addAuthor($authorId);
                            $post->setBody('Effectiveness, civil society promising development emergency response inspire breakthroughs action insurmountable challenges fairness. Political; network investment; poverty humanitarian relief educate catalyze agency beneficiaries. Equality results tackling sustainable rural development integrity partnership UNHCR board of directors. UNICEF world problem solving advocate climate change urban. Breakthrough insights, prevention; sanitation, Cesar Chavez public service sustainable future rural. Elevate, public institutions mobilize, innovation disrupt giving. Tackle, design thinking synthesize, crisis situation progress. Disruption Bono campaign, inclusive organization replicable assistance future accessibility');

                            $categoryId = $this->getDoctrine()
                                ->getRepository('NimaBlogBundle:Categories')
                                ->find('4');
                            if (!$categoryId) {
                                throw $this->createNotFoundException(
                                    'No category id'
                                );
                            }
                                $post->setCategory($categoryId);
                                $post->setEnabled('true');
                                $post->setHashtag('dd');
                                $post->setRating('10');
                                $post->setDataCreate('2016-12-02');
                                $em = $this->getDoctrine()->getManager();
                                $em->persist($post);
                                $em->flush();




                $post = new Posts();
                $post->setName('fgffg');
                $post->setDescription('Foster, treatment pursue these aspirations nonprofit; equity initiative disruptor');


                $authorId = $this->getDoctrine()
                    ->getRepository('NimaBlogBundle:Users')
                    ->find('1');
                if (!$authorId) {
                    throw $this->createNotFoundException(
                        'No author id'
                    );
                }
                $post->addAuthor($authorId);
                $post->setBody('Peaceful plumpy\'nut strengthen democracy, Aga Khan breakthrough insights. Innovation Medecins du Monde, micro-finance collaborative consumption think tank. Effectiveness resourceful public institutions solutions inspire breakthroughs; Ford Foundation democratizing the global financial system approach meaningful work. Economic development; lifting people up crisis management community diversity economic security. NGO raise awareness change movements; social, developing nations humanitarian relief challenges initiative courageous. Mobilize dignity, billionaire philanthropy nonviolent resistance Angelina Jolie accelerate progress. Combat malaria best practices cornerstone effect working families experience in the field legitimize dedicated. Liberal; overcome injustice safeguards hack, civil society celebrate. Deep engagement future humanitarian transform gun control theory of social change Jane Addams amplify nonprofit. Enable, results safety proper resources positive social change education human potential assessment expert. Jane Jacobs fighting poverty vaccines affiliate progressive. Improving quality fellows aid; gender equality social innovation maximize shifting landscape. Tackling human rights, beneficiaries equity board of directors. Assistance developing medical supplies worldwide, thinkers who make change happen tackle open source. Respond non-partisan disruptor momentum involvement pathway to a better life. Natural resources contribution local; research health. Frontline; insurmountable challenges; technology political, Rosa Parks Bloomberg underprivileged conflict resolution. United Nations pride social impact shift socio-economic divide. Kickstarter, action catalyst equal opportunity donate international development disruption minority. Eradicate, collaborative; cross-cultural medical organization; necessities working alongside human-centered design Cesar Chavez. Social good altruism evolution change lives youth educate. Impact; free expression; efficient, new approaches, partner, agriculture making progress affordable health care treatment. Medicine, global leaders, world problem solving gender freedom foster stakeholders. Advancement opportunity, advocate refugee; honor, public sector, human experience cooperation. Rural development social responsibility process smart cities, expanding community ownership accessibility informal economies prevention. Globalization, implementation poverty, citizenry provide solve, combat HIV/AIDS social analysis. Replicable Millennium Development Goals policy dialogue, volunteer public service truth development carbon emissions reductions. Sanitation Global South Bill and Melinda Gates sustainable transform the world free-speech elevate transformative global. Accelerate; reproductive rights, innovate network clean water visionary crisis situation.');

                $categoryId = $this->getDoctrine()
                    ->getRepository('NimaBlogBundle:Categories')
                    ->find('5');
                if (!$categoryId) {
                    throw $this->createNotFoundException(
                        'No category id'
                    );
                }
                $post->setCategory($categoryId);
                $post->setEnabled('true');
                $post->setHashtag('dd');
                $post->setRating('5');
                $post->setDataCreate('2016-12-01');
                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();

                $post = new Posts();
                $post->setName('kjkjkjkjkj');
                $post->setDescription('Foster, treatment pursue these aspirations nonprofit; equity initiative disruptor');


                $authorId = $this->getDoctrine()
                    ->getRepository('NimaBlogBundle:Users')
                    ->find('1');
                if (!$authorId) {
                    throw $this->createNotFoundException(
                        'No author id'
                    );
                }
                $post->addAuthor($authorId);
                $post->setBody('Effectiveness, civil society promising development emergency response inspire breakthroughs action insurmountable challenges fairness. Political; network investment; poverty humanitarian relief educate catalyze agency beneficiaries. Equality results tackling sustainable rural development integrity partnership UNHCR board of directors. UNICEF world problem solving advocate climate change urban. Breakthrough insights, prevention; sanitation, Cesar Chavez public service sustainable future rural. Elevate, public institutions mobilize, innovation disrupt giving. Tackle, design thinking synthesize, crisis situation progress. Disruption Bono campaign, inclusive organization replicable assistance future accessibility');

                $categoryId = $this->getDoctrine()
                    ->getRepository('NimaBlogBundle:Categories')
                    ->find('5');
                if (!$categoryId) {
                    throw $this->createNotFoundException(
                        'No category id'
                    );
                }
                $post->setCategory($categoryId);
                $post->setEnabled('true');
                $post->setHashtag('dd');
                $post->setRating('10');
                $post->setDataCreate('2016-12-02');
                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();

             */



    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}
