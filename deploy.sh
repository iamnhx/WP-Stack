#!/bin/bash

## Bash Variables  ##
export LC_ALL=C
OS_VERSION=`lsb_release -ds`
NETWORK_INTERFACE=`ip route get 1.1.1.1 | head -n1 | awk '{print $5}'`
IPV4_ADDRESS=`ip addr show $NETWORK_INTERFACE | grep "inet " | awk '{ print $2;exit }' | cut -d/ -f1`
IPV6_ADDRESS=`ip addr show $NETWORK_INTERFACE | grep "inet6 " | awk '{ print $2;exit }' | cut -d/ -f1`

NOCOLOR='\033[0m'
DARKRED='\033[0;31m'
LIGHTRED='\033[1;31m'
ORANGE='\033[0;33m'
YELLOW='\033[1;33m'
DARKGREEN='\033[0;32m'
LIGHTGREEN='\033[1;32m'
DARKCYAN='\033[0;36m'
LIGHTCYAN='\033[1;36m'
DARKBLUE='\033[0;34m'
LIGHTBLUE='\033[1;34m'
DARKPURPLE='\033[0;35m'
LIGHTPURPLE='\033[1;35m'
PURPLE='\033[0;35m'
PINK='\033[1;35m'
DARKGRAY='\033[1;30m'
LIGHTGRAY='\033[0;37m'
WHITE='\033[1;37m'

echo -e ""
echo -e "${LIGHTGRAY}################################################################################${NOCOLOR}"
echo -e "${LIGHTGRAY}Toolkit            :  ${LIGHTGREEN}WP-Stack${NOCOLOR}"
echo -e "${LIGHTGRAY}OS Version         :  ${LIGHTGREEN}$OS_VERSION${NOCOLOR}"
echo -e "${LIGHTGRAY}IP Address (IPv4)  :  ${LIGHTGREEN}$IPV4_ADDRESS${NOCOLOR}"
echo -e "${LIGHTGRAY}IP Address (IPv6)  :  ${LIGHTGREEN}$IPV6_ADDRESS${NOCOLOR}"
echo -e "${LIGHTGRAY}################################################################################${NOCOLOR}"
echo -e ""
sleep 1

## Setup project variables ##
echo ""
echo -e "${LIGHTPURPLE}============================================${NOCOLOR}"
echo -e "${LIGHTPURPLE}| Please enter project related variables...${NOCOLOR}"
echo -e "${LIGHTPURPLE}============================================${NOCOLOR}"
echo ""

echo ""
echo -e "${LIGHTCYAN}Enter your site tld (e.g. mydomain.com):${NOCOLOR}"
read SITE_TLD

echo ""
echo -e "${LIGHTCYAN}Enter your domain name (e.g. www.mydomain.com):${NOCOLOR}"
read DOMAIN

echo ""
echo -e "${LIGHTCYAN}Enter your desired database name:${NOCOLOR}"
read DB_NAME

echo ""
echo -e "${LIGHTCYAN}Enter your desired database user(non-root):${NOCOLOR}"
read DB_USER

echo ""
echo -e "${LIGHTCYAN}Enter your desired database user password(non-root):${NOCOLOR}"
randomPassword=$(openssl rand -hex 32)
read -e -i "$randomPassword" -a DB_PASSWORD_USER

echo ""
echo -e "${LIGHTCYAN}Enter your desired database password(root):${NOCOLOR}"
randomPassword=$(openssl rand -hex 32)
read -e -i "$randomPassword" -a DB_PASSWORD_ROOT

echo ""
echo -e "${LIGHTCYAN}Enter your desired email:${NOCOLOR}"
read EMAIL


echo ""
echo -e "${LIGHTRED}============================================${NOCOLOR}"
echo ""
echo "Please confirm that your project variables are valid to continue"
echo ""
echo -e "Site TLD: ${LIGHTGREEN}$SITE_TLD${NOCOLOR}"
echo -e "Domain Name: ${LIGHTGREEN}$DOMAIN${NOCOLOR}"
echo -e "DB_NAME: ${LIGHTGREEN}$DB_NAME${NOCOLOR}"
echo -e "DB_USER: ${LIGHTGREEN}$DB_USER${NOCOLOR}"
echo -e "DB_PASSWORD_USER: ${LIGHTGREEN}$DB_PASSWORD_USER${NOCOLOR}"
echo -e "DB_PASSWORD_ROOT: ${LIGHTGREEN}$DB_PASSWORD_ROOT${NOCOLOR}"
echo -e "EMAIL: ${LIGHTGREEN}$EMAIL${NOCOLOR}"
echo ""
echo -e "${LIGHTRED}============================================${NOCOLOR}"

echo ""
echo -e "${LIGHTGREEN}This might take a while...${NOCOLOR}"
echo ""

sudo apt update
sudo apt -y upgrade
sudo apt -y install git
sudo apt -y install nginx-extras
sudo apt -y install php7.4-fpm php7.4-bcmath php7.4-curl php7.4-gd php7.4-imagick php7.4-json php7.4-mbstring php7.4-mysql php7.4-soap php7.4-sqlite3 php7.4-xml php7.4-zip
sudo apt -y install certbot
sudo apt -y install php-redis
sudo apt -y install composer
sudo apt -y install php-xmlwriter ## required by composer
sudo apt -y install php7.4-curl ## required by composer
sudo apt -y install unzip ## required by composer
sudo apt -y install subversion ## for cloning Github repo
sudo apt -y install pwgen

wait

## import WP-Stack ##
cd /var
svn export --force https://github.com/iamnhx/WP-Stack/trunk/www
svn export --force https://github.com/iamnhx/WP-Stack/trunk/scripts

wait

## Create new swapfile ##
sudo chown root:root /var/www/cache/system ## must be root:root
sudo chmod 0600 /var/www/cache/system ## must be 0600
sudo fallocate -l 4G /var/www/cache/system/swapfile
sudo chown root:root /var/www/cache/system/swapfile ## must be root:root
sudo chmod 0600 /var/www/cache/system/swapfile ## must be 0600
sudo mkswap /var/www/cache/system/swapfile
sudo swapon /var/www/cache/system/swapfile
echo "/var/www/cache/system/swapfile none swap sw 0 0" | sudo tee -a /etc/fstab >/dev/null

## Create directories and assigning ownerships
sudo mkdir /var/www/html/.well-known
sudo mkdir /var/www/html/.well-known/acme-challenge
sudo mkdir /var/www/logs
sudo mkdir /var/www/sites
sudo chown www-data:www-data /var/www/cache ## must be www-data:www-data
sudo chown www-data:www-data /var/www/cache/nginx ## must be www-data:www-data
sudo chown www-data:www-data /var/www/cache/opcache ## must be www-data:www-data (PHP-FPM pool)
sudo chown -R www-data:www-data /var/www/html/.well-known ## must be www-data:www-data
sudo chown -R www-data:www-data /var/www/html/.well-known/acme-challenge ## must be www-data:www-data
sudo chown www-data:www-data /var/www/logs ## must be www-data:www-data


## Nginx conf ##
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/nginx/nginx.conf /etc/nginx/nginx.conf
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/nginx/default /var/www/sites/default
wait
sudo systemctl restart nginx

## PHP-FPM conf ##
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/php/php.ini /etc/php/7.4/fpm/php.ini
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/php/php-fpm.conf /etc/php/7.4/fpm/php-fpm.conf
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/php/www.conf /etc/php/7.4/fpm/pool.d/www.conf
wait
sudo systemctl restart php7.4-fpm

## Generate Let's Encrypt Cert ##
sudo certbot certonly --webroot --webroot-path=/var/www/html --email ${EMAIL} --agree-tos --no-eff-email --force-renewal -d ${SITE_TLD} -d ${DOMAIN}
sudo rm -rf /var/www/sites/default
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/nginx/server_blocks /var/www/sites/${SITE_TLD}
wait
sed -i "s/@SITE_TLD/${SITE_TLD}/g" /var/www/sites/${SITE_TLD}
sed -i "s/@SITE_DOMAIN/${DOMAIN}/g" /var/www/sites/${SITE_TLD}
sudo systemctl restart nginx

## Redis Installation ##
mkdir /etc/redis
mkdir /var/run/redis/
mkdir /var/lib/redis
mkdir /var/log/redis
sudo apt -y install tcl pkg-config build-essential
cd
sudo wget http://download.redis.io/redis-stable.tar.gz
sudo tar xvzf redis-stable.tar.gz
cd redis-stable
sudo make 
wait
sudo make test
wait
sudo make install
wait
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/redis/redis /etc/init.d/redis_6379
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/redis/redis.conf /etc/redis/redis.conf
wait
chmod +x /etc/init.d/redis_6379
sudo update-rc.d redis_6379 defaults
cd
sudo git clone --recursive https://github.com/RediSearch/RediSearch.git
cd RediSearch
sudo make setup
wait
sudo make build
wait
cp build/redisearch.so /etc/redis/redisearch.so
update-rc.d redis_6379 defaults
sudo /etc/init.d/redis_6379 start

## Debian does not ship mysql packages. Manual intervention required ##
sudo wget https://repo.mysql.com//mysql-apt-config_0.8.19-1_all.deb
sudo apt -y install ./mysql-apt-config_0.8.19-1_all.deb
sudo apt update
sudo apt -y install mysql-server
wait

## MySQL config ##
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/mysql/my.cnf /etc/mysql/my.cnf
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/mysql/mysql.cnf /etc/mysql/mysql.cnf
wait
sudo systemctl restart mysql

## Create databases ##
sudo mysql -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\`;"

## Create limited user for WordPress database ##
sudo mysql -e "ALTER USER IF EXISTS \`${DB_USER}\`@'localhost' IDENTIFIED WITH caching_sha2_password BY '${DB_PASSWORD_USER}';"
sudo mysql -e "ALTER USER IF EXISTS \`${DB_USER}\`@'127.0.0.1' IDENTIFIED WITH caching_sha2_password BY '${DB_PASSWORD_USER}';"
sudo mysql -e "ALTER USER IF EXISTS \`${DB_USER}\`@'::1' IDENTIFIED WITH caching_sha2_password BY '${DB_PASSWORD_USER}';"
sudo mysql -e "CREATE USER IF NOT EXISTS \`${DB_USER}\`@'localhost' IDENTIFIED WITH caching_sha2_password BY '${DB_PASSWORD_USER}';"
sudo mysql -e "CREATE USER IF NOT EXISTS \`${DB_USER}\`@'127.0.0.1' IDENTIFIED WITH caching_sha2_password BY '${DB_PASSWORD_USER}';"
sudo mysql -e "CREATE USER IF NOT EXISTS \`${DB_USER}\`@'::1' IDENTIFIED WITH caching_sha2_password BY '${DB_PASSWORD_USER}';"

## Grant limited user privileges on WordPress database only (localhost/IPv4/IPv6) ##
sudo mysql -e "GRANT ALL ON \`${DB_NAME}\`.* TO \`${DB_USER}\`@'localhost';"
sudo mysql -e "GRANT ALL ON \`${DB_NAME}\`.* TO \`${DB_USER}\`@'127.0.0.1';"
sudo mysql -e "GRANT ALL ON \`${DB_NAME}\`.* TO \`${DB_USER}\`@'::1';"

## Ensure root@localhost user is using auth_socket ##
sudo mysql -e "ALTER USER IF EXISTS 'root'@'localhost' IDENTIFIED WITH auth_socket BY '';"
sudo mysql -e "CREATE USER IF NOT EXISTS 'root'@'localhost' IDENTIFIED WITH auth_socket BY '';"
sudo mysql -e "GRANT ALL ON *.* TO 'root'@'localhost' WITH GRANT OPTION;"

## flush privileges ##
sudo mysql -e "FLUSH PRIVILEGES;"
wait
sed -i "s/@DOMAIN/${DOMAIN}/g" /var/www/html/.env.example
sed -i "s/@DB_NAME/${DB_NAME}/g" /var/www/html/.env.example
sed -i "s/@DB_USER/${DB_USER}/g" /var/www/html/.env.example
sed -i "s/@DB_PASSWORD_USER/${DB_PASSWORD_USER}/g" /var/www/html/.env.example

## Generate random salts for wp ##
cd /var/scripts
bash ./genwpsalts.sh | tee -a /var/www/html/.env.example 
mv /var/www/html/.env.example  /var/www/html/.env

## Composer create project ##
cd /var/www/html
sudo composer update -n

## Optimize system kernels ##
sudo svn export --force https://github.com/iamnhx/WP-Stack/trunk/configs/sysctl.conf /etc/sysctl.conf
wait
sudo sysctl -p
sudo chown -R www-data:www-data /var/www/html/web
echo -e "${LIGHTGREEN}Setup is now complete :)${NOCOLOR}"
