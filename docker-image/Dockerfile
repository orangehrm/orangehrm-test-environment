FROM orangehrm/orangehrm-environment-images:prod-7.3.5-ING

MAINTAINER orangehrm
LABEL authors = "OrangeHRM TechOps <techops@orangehrm.com>"

# install dependent software
RUN yum install -y gcc-c++ make
RUN curl -sL https://rpm.nodesource.com/setup_6.x | bash -

RUN touch /etc/yum.repos.d/wandisco-svn.repo
RUN echo $'[WandiscoSVN] \nname=Wandisco SVN Repo \nbaseurl=http://opensource.wandisco.com/centos/7/svn-1.9/RPMS/$basearch/ \nenabled=1 \ngpgcheck=0 ' > /etc/yum.repos.d/wandisco-svn.repo
#installing nodejs
RUN yum -y install \
    bzip2 \
    git \
    nmap \
    nodejs \
    sendmail \
    subversion mod_dav_svn \
    vim \
    && yum -y update bash \
    && rm -rf /var/cache/yum/* \
    && yum clean all
# Our user in the container
USER root
# set working dir as the installer directory
WORKDIR /var/www/html/installer/

#install bower and gulp
RUN npm install bower gulp nodemon node-sass pm2 -g

#update node to latest versions
RUN npm cache clean -f
RUN npm install -g n
RUN npm install -g npm
RUN n stable

# install php-ast module
RUN /usr/local/lib/php/bin/pecl install ast
RUN echo "\nextension=ast.so" >> /usr/local/lib/php/lib/php.ini

#install php-stats module
RUN /usr/local/lib/php/bin/pecl install stats-2.0.3
RUN echo "extension=stats.so" >> /usr/local/lib/php/lib/php.ini


# temporary switch on the "allow_url_fopen" to install composer and phan
RUN sed -i 's:^allow_url_fopen = Off$:allow_url_fopen = On:g' /usr/local/lib/php/lib/php.ini

# installing composer
RUN curl -sS https://getcomposer.org/installer | /usr/local/lib/php/bin/php -- --install-dir=/usr/local/bin --filename=composer

#add vhost config
COPY config/apache2-sites/orangehrm.conf /etc/httpd/vhosts/orangehrm.conf
COPY config/apache2-sites/000-default.conf /etc/httpd/vhosts/000-default.conf
COPY config/cert/orangehrm.crt /etc/httpd/cert/orangehrm.crt
COPY config/cert/orangehrm.key /etc/httpd/cert/orangehrm.key

# copy configuration files

COPY phpunit-5.7.21.phar /usr/bin/phpunit
COPY phpunit-3.7.28.phar /usr/bin/phpunit3
COPY phpunit-7.5.14.phar /usr/bin/phpunit7
COPY phpunit-8.2.5.phar /usr/bin/phpunit8

RUN  chmod +x /usr/bin/phpunit
RUN  chmod +x /usr/bin/phpunit3
RUN  chmod +x /usr/bin/phpunit7
RUN  chmod +x /usr/bin/phpunit8
#CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

ENV PATH="/usr/local/lib/php/bin:${PATH}"

# installing phan
RUN cd /var/lib && composer require --dev phan/phan
RUN ln -s /var/lib/vendor/bin/phan /usr/bin/phan

# enable and configure xdebug
RUN /usr/local/lib/php/bin/pecl install xdebug-2.9.2


# temporary switch on the "allow_url_fopen" to install composer and phan
RUN sed -i 's:^allow_url_fopen = On$:allow_url_fopen = Off:g' /usr/local/lib/php/lib/php.ini

#installing nc command
RUN yum install -y nmap-ncat
