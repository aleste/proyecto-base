Proyecto Base
========================

Base para el desarrollo de aplicaciones basadas en Symfony >= 2.3

Instalación
----------------------------------

Clonar el proyecto:

    git clone USUARIO@dionisio.desa.apronline.gov.ar:/var/gitrepos/proyecto-base.git

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

Crear usuario de administración:

Defina un usuario para la administración del sistema:

    php app/console fos:user:create admin   (Defina un email y una contraseña para el usuario)
    php app/console fos:user:promote admin  (Setee el valor ROLE_SUPER_ADMIN)

Publicar assets:

    php app/console assets:install web
    php app/console assetic:dump web

