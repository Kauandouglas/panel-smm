<?php
/**
 * @see https://github.com/artesaos/seotools
 */

$title = 'Sociei - Painel Seguidores Oficial: Tenha mais curtidas e visualizações!🏅';
$description = "Aumente a interação em suas redes sociais, como o Instagram. Obtenha um impulso em seguidores, alcance e interações em suas postagens!";
return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults' => [
            'title' => false, // set false to total remove
            'titleBefore' => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => $description, // set false to total remove
            'separator' => ' - ',
            'keywords' => [],
            'canonical' => 'https://sociei.com/', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots' => 'index', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title' => $title, // set false to total remove
            'description' => $description, // set false to total remove
            'url' => 'https://sociei.com/', // Set null for using Url::current(), set false to total remove
            'type' => 'website',
            'site_name' => 'Sociei',
            'images' => ['https://sociei.com/sociei253.png'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card' => 'summary',
            'site' => 'socieicombr',
            'creator' => 'socieicombr',
            'image' => 'https://sociei.com/sociei253.png'
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title' => $title, // set false to total remove
            'description' => $description, // set false to total remove
            'url' => 'https://sociei.com/', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type' => 'WebPage',
            'images' => ['https://sociei.com/sociei253.png'],
        ],
    ],
];
