

test:
  php artisan test --parallel --processes=4

test-coverage:
  php -dpcov.enabled=1 artisan test --coverage-html=covhtml

dev:
  npm run watch & php artisan serve
