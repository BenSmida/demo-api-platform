# demo-api-platform

```sh 
composer install

mkdir config/jwt

openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096

openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout

chmod -R 755 config/jwt

cp .env .env.local (et configurer la base)

php bin/console doctrine:database:create

php bin/console doctrine:schema:update --force

# app:create-user fullname username password role
php bin/console app:create-user administrateur admin@test.com admin admin

php bin/console app:create-user utilisateur user@test.com user user