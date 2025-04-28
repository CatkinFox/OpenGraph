<?php return [
    'plugin' => [
        'name' => 'OpenGraph Bildgenerator',
        'description' => 'Generiert automatisch OpenGraph-Bilder für CMS-Seiten.',
    ],
    'permissions' => [
        'access_settings' => 'Zugriff auf OpenGraph-Generierungseinstellungen',
        'tab' => 'OpenGraph',
    ],
    'settings' => [
        'label' => 'OpenGraph-Einstellungen',
        'description' => 'Hintergrundbild, Schriftart, Textplatzierung und Farben verwalten.',
        'keywords' => 'opengraph og bild soziale medien seo schriftart farbe',
        'background_image' => [
            'label' => 'Hintergrundbild',
            'comment_above' => 'Laden Sie das Basis-Hintergrundbild für Ihre OpenGraph-Tags hoch.',
            'comment' => 'Empfohlene Größe: 1200 Pixel Breite mal 630 Pixel Höhe. Bilder mit anderen Abmessungen werden möglicherweise nicht korrekt angezeigt.',
        ],
        'font_file' => [
            'label' => 'Schriftdatei',
            'comment_above' => 'Laden Sie die TrueType-Schriftdatei (.ttf) hoch, die für den Titeltext verwendet werden soll.',
            'comment' => 'Nur das .ttf-Format wird unterstützt.',
        ],
        'text_position' => [
            'label' => 'Textposition',
            'comment' => 'Wählen Sie aus, wo der Seitentiteltext auf dem Bild platziert werden soll.',
            'center_top' => 'Mitte Oben',
            'center_middle' => 'Mitte Mitte',
            'center_bottom' => 'Mitte Unten',
            'left_top' => 'Links Oben',
            'left_middle' => 'Links Mitte',
            'left_bottom' => 'Links Unten',
            'right_top' => 'Rechts Oben',
            'right_middle' => 'Rechts Mitte',
            'right_bottom' => 'Rechts Unten',
        ],
        'font_size' => [
            'label' => 'Schriftgröße (Pixel)',
            'comment' => 'Geben Sie die Schriftgröße in Pixel für den überlagerten Text ein.',
        ],
        'font_color' => [
            'label' => 'Schriftfarbe',
            'comment' => 'Wählen Sie die Farbe für den überlagerten Text.',
        ],
        'imagick_status' => [
            'not_found_title' => 'ImageMagick nicht gefunden',
            'not_found_desc' => 'Die erforderliche PHP-Erweiterung ImageMagick (imagick) ist auf Ihrem Server nicht installiert oder aktiviert. Dieses Plugin benötigt ImageMagick, um Bilder zu generieren. Bitte installieren/aktivieren Sie es und stellen Sie sicher, dass es korrekt konfiguriert ist.',
        ],
        'cache' => [
            'clear_button_label' => 'Generierten Bild-Cache leeren',
            'clear_confirm' => 'Sind Sie sicher, dass Sie alle generierten OpenGraph-Bilder leeren möchten? Sie werden bei Bedarf neu generiert.',
            'clear_indicator' => 'Cache wird geleert...',
            'clear_comment' => 'Klicken Sie auf diese Schaltfläche, um alle zwischengespeicherten OpenGraph-Bilder zu löschen.',
            'clear_success' => 'OpenGraph-Bild-Cache erfolgreich geleert!',
            'clear_fail' => 'Fehler beim Löschen des OpenGraph-Bild-Cache-Verzeichnisses. Überprüfen Sie die Berechtigungen für storage/app/media/opengraph/generated.',
            'clear_empty' => 'Das OpenGraph-Bild-Cache-Verzeichnis existiert nicht (bereits leer).',
            'clear_error' => 'Beim Leeren des Caches ist ein unerwarteter Fehler aufgetreten. Überprüfen Sie die Systemprotokolle.',
        ],
    ],
    'validation' => [
        'font_file_required' => 'Bitte laden Sie eine Schriftdatei hoch.',
        'font_size_required' => 'Bitte geben Sie eine Schriftgröße ein.',
        'font_size_numeric' => 'Die Schriftgröße muss eine Zahl sein.',
        'font_size_min' => 'Die Schriftgröße muss mindestens 10 betragen.',
        'font_size_max' => 'Die Schriftgröße darf 150 nicht überschreiten.',
        'font_color_required' => 'Bitte wählen Sie eine Schriftfarbe.',
    ],
    'component' => [
        'name' => 'OpenGraph Bild',
        'description' => 'Generiert und fügt das OpenGraph-Bild-Meta-Tag ein.',
        'custom_title' => [
            'title' => 'Benutzerdefinierter Titel',
            'description' => 'Überschreiben Sie optional den Seitentitel, der für den OpenGraph-Bildtext verwendet wird.',
        ],
        'generation_fail_warning' => 'OpenGraph Bild: Bildgenerierung für Seite fehlgeschlagen: :page',
        'config_warning' => 'OpenGraph Bild: Hintergrundbild oder Schriftdatei nicht in den Einstellungen konfiguriert.',
    ],
]; 