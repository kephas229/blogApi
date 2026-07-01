<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Blogs;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
        public function run(): void
    {
        // 1. Création des 2 utilisateurs Administrateurs
        $admin1 = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@blogact.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $admin2 = User::create([
            'name' => 'Sarah Directrice',
            'email' => 'sarah@blogact.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Liste de 10 articles avec images réelles d'Internet (Unsplash)
        $blogsData = [
            [
                'title' => 'Découvrir React en 2026',
                'shortDesc' => 'Un guide complet pour appréhender l\'écosystème React et ses nouvelles fonctionnalités cette année.',
                'Description' => '<p>React reste la bibliothèque JavaScript incontournable pour le développement frontend. Découvrez comment utiliser au mieux le routage et la gestion d\'état moderne.</p>',
                'author' => 'Super Admin',
                'image' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=800',
                'user_id' => $admin1->id
            ],
            [
                'title' => 'Maîtriser les API avec Laravel',
                'shortDesc' => 'Pourquoi coupler Laravel et React est le meilleur choix architectural pour vos applications Single Page.',
                'Description' => '<p>Laravel Breeze et Sanctum simplifient drastiquement la création d\'API REST robustes et la gestion sécurisée de l\'authentification par cookie.</p>',
                'author' => 'Sarah Directrice',
                'image' => 'https://images.unsplash.com/photo-1607799279861-4dd421887fb3?w=800',
                'user_id' => $admin2->id
            ],
            [
                'title' => 'Le Guide Complet de Bootstrap 5',
                'shortDesc' => 'Apprenez à structurer vos grilles et utiliser les classes flexbox pour des interfaces ultra-rapides.',
                'Description' => '<p>Grâce aux utilitaires comme d-flex et justify-content, aligner vos barres de navigation et vos formulaires devient un jeu d\'enfant.</p>',
                'author' => 'Super Admin',
                'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800',
                'user_id' => $admin1->id
            ],
            [
                'title' => 'L\'essor de l\'Intelligence Artificielle',
                'shortDesc' => 'Comment les outils d\'IA transforment le quotidien des développeurs et accélèrent le codage.',
                'Description' => '<p>De la génération d\'images à la complétion de code, découvrez l\'impact réel des technologies génératives sur notre industrie.</p>',
                'author' => 'Sarah Directrice',
                'image' => 'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=800',
                'user_id' => $admin2->id
            ],
            [
                'title' => 'Conseils pour un Espace de Travail Minimaliste',
                'shortDesc' => 'Optimisez votre setup pour maximiser votre concentration et réduire la fatigue visuelle.',
                'Description' => '<p>Un bon écran, un clavier ergonomique et une plante verte suffisent souvent à transformer radicalement votre productivité quotidienne.</p>',
                'author' => 'Super Admin',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800',
                'user_id' => $admin1->id
            ],
            [
                'title' => 'Les secrets de la cybersécurité web',
                'shortDesc' => 'Protégez vos applications contre les failles CSRF, XSS et les injections de base de données.',
                'Description' => '<p>La sécurité ne doit jamais être négligée. Découvrez comment Laravel protège nativement vos requêtes HTTP via des mécanismes d\'authentification étanches.</p>',
                'author' => 'Sarah Directrice',
                'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800',
                'user_id' => $admin2->id
            ],
            [
                'title' => 'Tendances Design pour Interfaces Web',
                'shortDesc' => 'Polices modernes, espacements aérés et contrastes de couleurs à adopter d\'urgence.',
                'Description' => '<p>Le design d\'une application fait toute la différence. Privilégiez des structures dynamiques et évitez les textes collés aux bordures.</p>',
                'author' => 'Super Admin',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800',
                'user_id' => $admin1->id
            ],
            [
                'title' => 'Introduction aux bases de données NoSQL',
                'shortDesc' => 'Comprendre les différences majeures entre les modèles relationnels (SQL) et non-relationnels.',
                'Description' => '<p>Bien que Laravel brille avec MySQL et PostgreSQL, appréhender les structures documentaires s\'avère indispensable pour certains projets massifs.</p>',
                'author' => 'Sarah Directrice',
                'image' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800',
                'user_id' => $admin2->id
            ],
            [
                'title' => 'Organiser sa veille technologique',
                'shortDesc' => 'Les meilleures plateformes et newsletters pour rester constamment à jour sans s\'éparpiller.',
                'Description' => '<p>Dans notre industrie, tout change très vite. Suivre les bons créateurs sur GitHub, Reddit ou StackOverflow est la clé pour ne pas perdre le fil.</p>',
                'author' => 'Super Admin',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800',
                'user_id' => $admin1->id
            ],
            [
                'title' => 'Pourquoi voyager améliore votre code',
                'shortDesc' => 'Prendre du recul et changer d\'environnement aide à résoudre les bugs complexes.',
                'Description' => '<p>S\'éloigner de son écran et s\'ouvrir à de nouvelles cultures stimule la créativité et permet souvent de débloquer des problématiques logiques complexes.</p>',
                'author' => 'Sarah Directrice',
                'image' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=800',
                'user_id' => $admin2->id
            ],
        ];

        // Insertion des articles et stockage dans un tableau pour lier les commentaires
        $createdBlogs = [];
        foreach ($blogsData ?? [] as $data) {
            $createdBlogs[] = Blogs::create($data);
        }

        // 3. Génération de commentaires réalistes répartis aléatoirement
        $visitors = [
            ['name' => 'Lucas Martin', 'email' => 'lucas@gmail.com', 'msg' => 'Super article, très clair ! Merci pour le partage.'],
            ['name' => 'Emma Dubois', 'email' => 'emma.d@yahoo.fr', 'msg' => 'Je ne suis pas tout à fait d\'accord avec ce point, mais l\'explication reste excellente.'],
            ['name' => 'Thomas Moreau', 'email' => 't.moreau@outlook.com', 'msg' => 'Est-ce qu\'un dépôt de code exemple est disponible sur GitHub ?'],
            ['name' => 'Chloé Petit', 'email' => 'chloe.p@gmail.com', 'msg' => 'Exactement ce que je cherchais pour mon projet d\'études.'],
            ['name' => 'Antoine Roux', 'email' => 'antoine.roux@free.fr', 'msg' => 'Un tutoriel vidéo est-il prévu par la suite ?'],
            ['name' => 'Léa Garcia', 'email' => 'lea.garcia@gmail.com', 'msg' => 'Top ! Bootstrap facilite vraiment la vie pour l\'alignement horizontal.'],
            ['name' => 'Julien Lemaire', 'email' => 'j.lemaire@bureau.com', 'msg' => 'Lier Laravel et React a changé ma façon de travailler. Bon résumé.'],
            ['name' => 'Manon Bonnet', 'email' => 'manon@outlook.fr', 'msg' => 'Cet espace de travail donne envie d\'épurer son bureau immédiatement.'],
        ];

        foreach ($createdBlogs ?? [] as $blog) {
            // Sélectionne entre 1 et 3 commentaires aléatoires par article
            $numberOfComments = rand(1, 3);
            $selectedVisitors = array_rand($visitors, $numberOfComments);

            // Gérer le cas où array_rand retourne un seul élément au lieu d'un tableau
            $selectedVisitors = is_array($selectedVisitors) ? $selectedVisitors : [$selectedVisitors];

            foreach ($selectedVisitors ?? [] as $index) {
                Comment::create([
                    'blog_id' => $blog->id,
                    'visitor_name' => $visitors[$index]['name'],
                    'visitor_email' => $visitors[$index]['email'],
                    'message' => $visitors[$index]['msg'],
                ]);
            }
        }
    }
}
