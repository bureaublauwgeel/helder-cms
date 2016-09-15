FROM ubuntu:14.04
MAINTAINER Bureau BlauwGeel <info@bureaublauwgeel.nl>

RUN apt-get -yqq update
RUN apt-get -yqq install apache2
RUN apt-get -yqq install git php5 php5-gd php5-mysql php5-curl php5-mcrypt php5-xmlrpc php5-imagick php5-apcu php5-intl
RUN apt-get -yqq install curl

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2

RUN php5enmod gd mysql curl mcrypt xmlrpc imagick apcu intl
RUN a2enmod expires ssl rewrite headers mime_magic vhost_alias

RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOCK_DIR $APACHE_LOG_DIR /var/www
RUN chown $APACHE_RUN_USER:$APACHE_RUN_GROUP /var/www

ADD website.conf /etc/apache2/sites-available/

RUN ln -s /etc/apache2/sites-available/website.conf /etc/apache2/sites-enabled/website.conf
RUN rm /etc/apache2/sites-enabled/000-default.conf

RUN  echo "    IdentityFile ~/.ssh/id_rsa" >> /etc/ssh/ssh_config

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Add nodejs
RUN curl -sL https://deb.nodesource.com/setup_4.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm -g

# Add bundler
RUN apt-get install -y ruby
RUN gem install bundler

EXPOSE 80

ENTRYPOINT [ "/usr/sbin/apache2" ]
CMD ["-D", "FOREGROUND"]

