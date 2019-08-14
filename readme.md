composer install
./bin/console doctrine:migrations:migrate
.bin/console doctrine:fixtures:load
./bin/console server:start


All generated users password "root"
