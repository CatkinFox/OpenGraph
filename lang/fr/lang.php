<?php return [
    'plugin' => [
        'name' => 'Générateur d\'images OpenGraph',
        'description' => 'Génère automatiquement des images OpenGraph pour les pages CMS.',
    ],
    'permissions' => [
        'access_settings' => 'Accéder aux paramètres de génération OpenGraph',
        'tab' => 'OpenGraph',
    ],
    'settings' => [
        'label' => 'Paramètres OpenGraph',
        'description' => 'Gérer l\'image de fond, la police, le placement du texte et les couleurs.',
        'keywords' => 'opengraph og image réseaux sociaux seo police couleur',
        'background_image' => [
            'label' => 'Image de fond',
            'comment_above' => 'Téléchargez l\'image de fond de base pour vos balises OpenGraph.',
            'comment' => 'Taille recommandée : 1200px de large par 630px de haut. Les images avec des dimensions différentes peuvent ne pas s\'afficher correctement.',
        ],
        'font_file' => [
            'label' => 'Fichier de police',
            'comment_above' => 'Téléchargez le fichier de police TrueType (.ttf) à utiliser pour le texte du titre.',
            'comment' => 'Seul le format .ttf est pris en charge.',
        ],
        'text_position' => [
            'label' => 'Position du texte',
            'comment' => 'Sélectionnez où le texte du titre de la page doit être placé sur l\'image.',
            'center_top' => 'Centre Haut',
            'center_middle' => 'Centre Milieu',
            'center_bottom' => 'Centre Bas',
            'left_top' => 'Gauche Haut',
            'left_middle' => 'Gauche Milieu',
            'left_bottom' => 'Gauche Bas',
            'right_top' => 'Droite Haut',
            'right_middle' => 'Droite Milieu',
            'right_bottom' => 'Droite Bas',
        ],
        'font_size' => [
            'label' => 'Taille de police (pixels)',
            'comment' => 'Entrez la taille de la police en pixels pour le texte superposé.',
        ],
        'font_color' => [
            'label' => 'Couleur de la police',
            'comment' => 'Choisissez la couleur du texte superposé.',
        ],
        'imagick_status' => [
            'not_found_title' => 'ImageMagick non trouvé',
            'not_found_desc' => 'L\'extension PHP ImageMagick requise (imagick) n\'est pas installée ou activée sur votre serveur. Ce plugin nécessite ImageMagick pour générer des images. Veuillez l\'installer/l\'activer et vous assurer qu\'elle est correctement configurée.',
        ],
        'cache' => [
            'clear_button_label' => 'Vider le cache des images générées',
            'clear_confirm' => 'Êtes-vous sûr de vouloir vider toutes les images OpenGraph générées ? Elles seront régénérées à la demande.',
            'clear_indicator' => 'Vidage du cache...',
            'clear_comment' => 'Cliquez sur ce bouton pour supprimer toutes les images OpenGraph mises en cache.',
            'clear_success' => 'Le cache des images OpenGraph a été vidé avec succès !',
            'clear_fail' => 'Échec de la suppression du répertoire de cache des images OpenGraph. Vérifiez les autorisations pour storage/app/media/opengraph/generated.',
            'clear_empty' => 'Le répertoire de cache des images OpenGraph n\'existe pas (déjà vide).',
            'clear_error' => 'Une erreur inattendue s\'est produite lors du vidage du cache. Vérifiez les journaux système.',
        ],
    ],
    'validation' => [
        'font_file_required' => 'Veuillez télécharger un fichier de police.',
        'font_size_required' => 'Veuillez entrer une taille de police.',
        'font_size_numeric' => 'La taille de la police doit être un nombre.',
        'font_size_min' => 'La taille de la police doit être d\'au moins 10.',
        'font_size_max' => 'La taille de la police ne peut pas être supérieure à 150.',
        'font_color_required' => 'Veuillez sélectionner une couleur de police.',
    ],
    'component' => [
        'name' => 'Image OpenGraph',
        'description' => 'Génère et insère la balise méta de l\'image OpenGraph.',
        'custom_title' => [
            'title' => 'Titre personnalisé',
            'description' => 'Optionnellement, remplacez le titre de la page utilisé pour le texte de l\'image OpenGraph.',
        ],
        'generation_fail_warning' => 'Image OpenGraph : Échec de la génération de l\'image pour la page : :page',
        'config_warning' => 'Image OpenGraph : L\'image de fond ou le fichier de police n\'est pas configuré dans les paramètres.',
    ],
]; 