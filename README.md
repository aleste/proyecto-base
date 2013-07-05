Proyecto Base
========================

Base para el desarrollo de aplicaciones basadas en symfony2

Instalacion
----------------------------------

Clonar el proyecto:

    git clone USUARIO@dionisio.desa.apronline.gov.ar:/var/gitrepos/proyecto-base.git


Instalar Dependencias:

    php composer.php install


Configurar Permisos:

    sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs
    sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs


Configurar DB:

Renombrar el archivo parameters.dist.yml como parameters.yml y configurar los parametros de su base de datos

Ejecutar los siguientes comandos de consola:

    php app/console doctrine:database:create
    php app/console doctrine:schema:create


Publicar assets:

    php app/console assets:install web
    php app/console assetic:dump web

