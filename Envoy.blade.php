@servers(['local' => '127.0.0.1', 'nuros' => 'connection@nuros.unl.edu'])

@story('deploy')
  maintenance-on
  update-repo
  build-frontend
  run-migrations
  cache
  maintenance-off
@endstory

@task('maintenance-on', ['on' => 'nuros'])
  cd public_html/connection-main
  php artisan down
@endtask

@task('maintenance-off', ['on' => 'nuros'])
  cd public_html/connection-main
  php artisan up
@endtask

@task('build-frontend', ['on' => 'local'])
  npm ci
  npm run build
  tar -czf public.tar.gz public
  scp public.tar.gz connection@nuros.unl.edu:public_html/connection-main
  rm public.tar.gz
  ssh connection@nuros.unl.edu 'cd public_html/connection-main ; rm -rf public ; tar -xzf public.tar.gz ; rm public.tar.gz'
@endtask

@task('update-repo', ['on' => 'nuros'])
  cd public_html/connection-main
  git pull origin php-8.1
  php composer.phar install --optimize-autoloader --no-dev
@endtask

@task('run-migrations', ['on' => 'nuros'])
  cd public_html/connection-main
  php artisan migrate --force
@endtask

@task('cache', ['on' => 'nuros'])
  cd public_html/connection-main
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan storage:link
@endtask
