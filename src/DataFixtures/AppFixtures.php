<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Thumb;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $trickNames = [
            'Backside Air' => 'On commence tout simplement avec LE trick. Les mauvaises langues prétendent qu’un backside air suffit à reconnaître ceux qui savent snowboarder. Si c’est vrai, alors Nicolas Müller est le meilleur snowboardeur du monde. Personne ne sait s’étirer aussi joliment, ne demeure aussi zen, n’est aussi provocant dans la jouissance.',
            'One Foot Tricks' => 'Bode Merril est la preuve vivante que la réincarnation n’est pas un conte de fée. Dans sa vie antérieure de flamant rose, il avait déjà l’habitude d’affronter le quotidien sur une patte. Quelque 200 ans plus tard, il a eu la chance d’être un homme doté d’un snowboard, ce qui a fini par donner à son être l’élan nécessaire. Il aime bien s’avaler quelques one foot double backflips au p’tit déj.',
            'Switch Backside Rodeo 720' => 'Si l’univers du snowboard a jamais disposé d’un scientifique, alors c’était David Benedek. Personne mieux que lui n’a su comment monter un kicker pour qu’un trick marche bien. En musique, on qualifie cela d’expérimental. Ce n’est pas un hasard si c’est précisément lui qui a eu l’idée de faire un switch BS rodeo.',
            'BS 540 Seatbelt' => 'Hitsch aurait tout aussi bien pu faire de la danse classique mais il s’est décidé pour la neige. Peut-être tout simplement parce qu’en Engadine, les montagnes sont plus séduisantes que les gymnases. Quoi qu’il en soit, quiconque arrive à attraper aussi tranquillement l’arrière de la planche avec la main avant pendant un BS 5 dans un half-pipe sans s’ouvrir les lèvres sur le coping devrait occuper une chaire à Cambridge sur les prodiges de la coordination.',
            'FS 720 Japan' => 'Si, dans le monde du snowboard, il y avait aujourd’hui encore quelque chose de comparable au rock’n’roll, Ben Ferguson en serait le Jim Morrison, haut la main. Son riding est radical, sans compromis et beau à voir. Bien entendu, rien ne se fait à moins de 200 km/h, pas même les FS 7 Japan dans le pipe.',
            'Skate Skills' => 'Scott «MacGyver» Stevens n’aurait en fait pas besoin de forfait de remontée. Scott n’aurait même pas besoin d’aller à la montagne. Scott a juste à sortir de chez lui, respirer un bon coup et démarrer. Après trois jours de tournage, son rôle serait plus long et plus créatif que pour ceux qui ont dû passer 20 heures en avion, 10 heures en voiture, 5 heures en Ski-Doo et 2 heures en hélicoptère pour leur séquence.',
            'Switch Method' => 'Danny Davis est comme ces meilleurs potes qui peuvent faire tous les tricks avec juste un tout petit plus de classe que toi. Aussi difficiles ou aussi faciles soient-ils. Si un nombre incalculable de blessures ne l’avait pas cloué au lit, il aurait mis sens dessus dessous le monde de la compétition en pipe. Heureusement qu’il y a la vidéo. Et puis on peut quand même se faire une compétition de temps en temps. Et alors on peut y mettre un peu de switch method pour faire tomber les juges à la renverse.',
            'Going bigger' => 'Soyons francs, tous les tricks de Travis pourraient être des signatures. Son genre «I go bigger» se voit probablement dès le matin aux toilettes. Trois fois par dessus la tête ou simply straight, il semble que Travis puisse à peu près tout essayer plus haut, plus loin, plus extrême, plus beau et en premier la plupart du temps.',
            'McTwist' => 'Terje se sent mieux dans les transitions que Trump dans sa tour. Pas étonnant, il a détenu pendant longtemps le record du highest air. En mars 2007 à Oslo, il s’est catapulté à un bon 9,8 mètres sur un quarterpipe. Pendant le saut, l’altitude l’a surpris lui-même, c’est pourquoi il a rapidement transformé la méthode prévue en un BS 360. Pourquoi se priver quand on peut. Les McTwists dans un half-pipe par contre c’est plutôt comme une fête d’anniversaire. On a besoin d’un peu d’alley-oop et de chicken wings pour trouver le frisson.',
            'Buttered Tricks' => 'Nommer son trick typique d’après sa propre marque de snowboard est plutôt osé. Les mômes regardent la vidéo, se disent «ouaouh», essaient d’imiter l’acrobatie et avant ça vont s’acheter la planche qu’il faut. D’apparence innocent comme un agneau, Halldor est en fait le businessman le plus dur à cuire d’Islande. Tout cela sans le vouloir évidemment.',
        ];

        $user = new User();
        $user
            ->setPseudonyme("LeZellus")
            ->setFirstname("Mathéo")
            ->setLastname("Zeller")
            ->setPassword(password_hash("Playmate12", PASSWORD_BCRYPT))
            ->setRoles(["ROLE_ADMIN"])
            ->setEmail("matheo.zeller@gmail.com")
            ->setIsVerified(true);
        $manager->persist($user);

        $user = new User();
        $user
            ->setPseudonyme("Visiteur")
            ->setFirstname("Jack")
            ->setLastname("Pot")
            ->setPassword(password_hash("visiteur", PASSWORD_BCRYPT))
            ->setRoles(["ROLE_USER"])
            ->setEmail("visiteur@exemple.fr")
            ->setIsVerified(true);
        $manager->persist($user);

        $user = new User();
        $user
            ->setPseudonyme("Admin")
            ->setFirstname("Admin")
            ->setLastname("Admin")
            ->setPassword(password_hash("Admin123", PASSWORD_BCRYPT))
            ->setRoles(["ROLE_ADMIN"])
            ->setEmail("admin@exemple.fr")
            ->setIsVerified(true);
        $manager->persist($user);

        $users[] = $user;

        foreach ($trickNames as $trickName => $desc) {
            $trick = new Trick();
            $trick
                ->setName($trickName)
                ->setDescription($desc)
                ->setCreatedAt()
                ->setUpdatedAt()
                ->setUser($faker->randomElement($users));

            /*
             * Add 3 Image per Trick
             */
            for ($k = 1; $k < 4; $k++) {
                $image = new Thumb();
                $image
                    ->setPath('img/tricks')
                    ->setType('.jpg')
                    ->setNewName($trick->getName())
                    ->setTrick($trick);
                if ($k == 1) {
                    $image->setIsMain(true);
                } else {
                    $image->setIsMain(false);
                };

                $manager->persist($image);
            }

            /*
             * Add 1 to 2 Video per Trick
             */
            for ($l = 0; $l < mt_rand(1, 2); $l++) {
                $video = new Video();
                $video
                    ->setCode('https://www.youtube.com/watch?v=tHHxTHZwFUw')
                    ->setTrick($trick);

                $manager->persist($video);
            }

            /*
             * Add 10 to 30 Comment per Trick
             */
            for ($m = 0; $m < mt_rand(10, 40); $m++) {
                $comment = new Comment();
                $comment
                    ->setContent($faker->sentence(6, false))
                    ->setCreatedAt(new \Datetime)
                    ->setUser($faker->randomElement($users))
                    ->setTrick($trick);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
