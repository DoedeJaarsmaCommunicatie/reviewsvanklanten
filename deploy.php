<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'reviews-van-klanten');

// Project repository
set('repository', 'git@github.com:DoedeJaarsmaCommunicatie/reviewsvanklanten.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

// Ignore platform reqs, server shows 7.2 but runs 7.3
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader --no-suggest --ignore-platform-reqs');

// Hosts
host()
    ->hostname('141.105.127.47')
    ->stage('production')
    ->roles('app')
    ->port(33)
    ->user('reviews')
    ->set('deploy_path', '~/domains/reviewsvanklanten.nl/public_html/dep');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

