


INSTALLATION INSTRUCTIONS:

1. composer install

2. Create DB and schema

- php bin/console doctrine:database:create
- php bin/console doctrine:schema:update --force

3. Load fixtures
php bin/console doctrine:fixtures:load --fixtures=src/LazyAnts/Bundle/FrontBundle/LoadDataFixtures/ORM


- command which parses soccerway.com: "php bin/console parse-results"