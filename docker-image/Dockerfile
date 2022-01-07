FROM orangehrm/orangehrm-environment-images:prod-php-7.4-ubuntu20.04

MAINTAINER orangehrm
LABEL authors = "OrangeHRM TechOps <techops@orangehrm.com>"

# install dependent software
RUN apt install build-essential \
    &&  gcc --version

RUN sh -c 'echo "deb http://opensource.wandisco.com/ubuntu focal svn19" >> /etc/apt/sources.list.d/subversion19.list'
RUN wget -q http://opensource.wandisco.com/wandisco-debian-new.gpg -O- |  apt-key add -
RUN apt-get update

#install Subverson
RUN apt-get install -y subversion

# Replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh
RUN mkdir /usr/local/nvm
ENV NVM_DIR /usr/local/nvm
ENV NODE_VERSION_D 6
ENV NODE_VERSION_L 14.17.5

#installing nodejs
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.34.0/install.sh | bash \
    && . $NVM_DIR/nvm.sh \  
    && nvm install $NODE_VERSION_D \
    && nvm alias default $NODE_VERSION_D \
    && nvm install $NODE_VERSION_L \
    && nvm alias latest $NODE_VERSION_L \
    && nvm ls \
    && nvm use default \ 
    && npm install bower -g \ 
    && npm install gulp -g \
    && npm install nodemon -g \
    && npm install -f node-sass \
    && npm install pm2 -g

ENV NODE_PATH_D $NVM_DIR/v$NODE_VERSION_D/lib/node_modules
ENV PATH_D      $NVM_DIR/v$NODE_VERSION_D/bin:$PATH

ENV NODE_PATH_L $NVM_DIR/v$NODE_VERSION_L/lib/node_modules
ENV PATH_L      $NVM_DIR/v$NODE_VERSION_L/bin:$PATH

RUN apt install -y \
    bzip2 \
    git \
    nmap \
    sendmail \
    libapache2-mod-svn \
    vim \
    && apt-get autoclean \
    && apt-get install --only-upgrade bash

# Our user in the container
USER root
# set working dir as the installer directory
WORKDIR /var/www/html/installer/

# set git system config to use https instead of git
RUN git config --system url."https://".insteadOf git://

#install bower and gulp
#RUN npm install bower gulp nodemon pm2 -g
#RUN npm install -f node-sass


# # install php-ast module
RUN pecl install ast
RUN echo "extension=ast.so" >> /etc/php.ini

# #install php-stats module
RUN pecl install stats-2.0.3
RUN echo "extension=stats.so" >> /etc/php.ini


# # temporary switch on the "allow_url_fopen" to install composer and phan
RUN sed -i 's:^allow_url_fopen = Off$:allow_url_fopen = On:g' /etc/php.ini

# # installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.20

#install mod_vhost_alias
RUN a2enmod vhost_alias

#Enable mod_expire module
RUN a2enmod expires

#add vhost config
COPY config/apache2-sites/orangehrm.conf /etc/apache2/sites-available/orangehrm.conf
COPY config/apache2-sites/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY config/cert/orangehrm.crt /etc/apache2/cert/orangehrm.crt
COPY config/cert/orangehrm.key /etc/apache2/cert/orangehrm.key
RUN rm /etc/apache2/sites-enabled/000-default.conf
RUN ln -s /etc/apache2/sites-available/orangehrm.conf /etc/apache2/sites-enabled/orangehrm.conf
RUN ln -s /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-enabled/000-default.conf


# copy configuration files
COPY config/mysql-client/my.cnf /etc/mysql/my.cnf
COPY config/mysql-client/conf.d /etc/mysql/conf.d
COPY config/db-check.sh /var/www/db-check.sh
COPY phpunit-5.7.21.phar /usr/bin/phpunit
COPY phpunit-3.7.28.phar /usr/bin/phpunit3
COPY phpunit-7.5.14.phar /usr/bin/phpunit7
COPY phpunit-8.2.5.phar /usr/bin/phpunit8

RUN  chmod +x /usr/bin/phpunit
RUN  chmod +x /usr/bin/phpunit3
RUN  chmod +x /usr/bin/phpunit7
RUN  chmod +x /usr/bin/phpunit8

# installing phan
RUN cd /var/lib && composer require --dev phan/phan
RUN ln -s /var/lib/vendor/bin/phan /usr/bin/phan

# enable and configure xdebug
RUN pecl install Xdebug

# temporary switch on the "allow_url_fopen" to install composer and phan
RUN sed -i 's:^allow_url_fopen = On$:allow_url_fopen = Off:g' /etc/php.ini

#installing nc command
RUN apt install -y netcat