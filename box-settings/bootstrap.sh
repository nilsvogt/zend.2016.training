#! /usr/bin/env bash

# assign the root directory of your server
document_root="/vagrant/app/public"
# set the database user
db_username="root"
# set the database pass
db_password="root"

function echoSection {
	tput setaf 5
	echo " "
	echo '---------------------------------------------------------------'
	echo '// '${1^^}
	echo '==============================================================='
}

# install curl
#
echoSection "> installing common tools..." &&
sudo apt-get install -y curl zip unzip >/dev/null &&

# add repository ppa:ondrej/php in order to install php7
#
echoSection "> adding repository ppa:ondrej/php..." &&
apt-get install software-properties-common >/dev/null &&
add-apt-repository -y ppa:ondrej/php >/dev/null &&
apt-get update >/dev/null &&

# install server (nginx)
#
echoSection "> installing nginx..." &&
sudo apt-get install -y nginx >/dev/null &&

# set nginx config
#
echoSection "> configuring nginx..." &&
sudo rm /etc/nginx/sites-available/default &&
sudo cp /vagrant/box-settings/nginx.default /etc/nginx/sites-available/default &&

# link document root
#
if ! [ -L /usr/share/nginx/html ]; then
  rm -rf /usr/share/nginx/html &&
  ln -fs ${document_root} /usr/share/nginx/html
fi

# install php7 stack
#
echoSection "> installing php7 stack..." &&
sudo apt-get install -y --force-yes php7.0-fpm php7.0 php7.0-mysql php7.0-curl php7.0-gd php7.0-intl php-pear php7.0-imap php7.0-mcrypt php7.0-sqlite3 snmp >/dev/null &&

# install xdebug
#
echoSection "> installing xdebug..."
sudo apt-get install -y php7.0-dev >/dev/null  &&
sudo pecl install xdebug >/dev/null  &&
sudo bash -c "cat /vagrant/box-settings/xdebug-php.ini >> /etc/php/7.0/fpm/php.ini" &&

# install mysql-server (without prompt)
#
echoSection "> installing mysql-server..." &&
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password '${db_username} >/dev/null &&
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password '${db_password} >/dev/null &&
sudo apt-get -y install mysql-server >/dev/null &&

# install mysql-client
#
echoSection "> installing mysql-client..." &&
sudo apt-get install -y mysql-client >/dev/null &&

# install phpunit
#
echoSection "> installing phpunit..." &&
wget https://phar.phpunit.de/phpunit.phar &&
chmod +x phpunit.phar &&
sudo mv phpunit.phar /usr/local/bin/phpunit &&

# install git
#
echoSection "> installing git..." &&
sudo apt-get install -y git >/dev/null &&

# install composer
#
echoSection "> installing composer..." &&
curl -Ss https://getcomposer.org/installer | php >/dev/null &&
mv composer.phar /usr/local/bin/composer &&

# bootstrap the public root
#
echoSection "> preparing document root..." &&
if [ ! -d ${document_root} ];  then
	# create public root
	mkdir -p ${document_root} &&
	# place php info
	echo "<?php phpinfo(); ?>" >> ${document_root}/index.php
fi
# bootstrap the database
#
echoSection "> bootstrapping database..." &&
if [ -e /vagrant/bootstrap.sql ]; then
	cat /vagrant/bootstrap.sql | mysql -u ${db_username} --password=${db_password}
fi

# restart server
#
echoSection "> restarting php-fqm and nginx..." &&
sudo service php7.0-fpm restart &&
sudo service nginx restart