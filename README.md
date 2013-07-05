Proyecto Base
========================

Base para el desarrollo de aplicaciones basadas en Symfony >= 2.3

Instalación
----------------------------------

Clonar el proyecto:

    git clone https://github.com/aleste/proyecto-base.git

Instalar dependencias:

    php composer.phar install


Configurar permisos:

    sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs
    sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs


Configurar DB:

Renombrar el archivo parameters.dist.yml como parameters.yml y configurar los parámetros de su base de datos

Ejecutar los siguientes comandos de consola:

    php app/console doctrine:database:create
    php app/console doctrine:schema:create
    php app/console doctrine:fixtures:load
    
Crear usuario de administración
    php app/console fos:user:create admin
    php app/console fos:user:promote admin

Publicar assets:

    php app/console assets:install web
    php app/console assetic:dump web

