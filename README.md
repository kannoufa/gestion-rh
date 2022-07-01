 ## Quick Start
    $ git clone https://github.com/kannoufa/gestion-rh.git
    $ cd gestion-rh
    $ composer install
    $ php bin/console doctrine:database:create
    $ php bin/console doctrine:migrations:migrate
    $ php bin/console doctrine:fixtures:load
    $ symfony serve