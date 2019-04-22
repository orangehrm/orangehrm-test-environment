FROM orangehrm/orangehrm-environment-images:prod-5.6-centos

MAINTAINER orangehrm
LABEL authors = "OrangeHRM TechOps <techops@orangehrm.com>"

RUN yum install -y gcc-c++ make
RUN curl -sL https://rpm.nodesource.com/setup_6.x | bash -

RUN touch /etc/yum.repos.d/wandisco-svn.repo
RUN echo $'[WandiscoSVN] \nname=Wandisco SVN Repo \nbaseurl=http://opensource.wandisco.com/centos/7/svn-1.9/RPMS/$basearch/ \nenabled=1 \ngpgcheck=0 ' > /etc/yum.repos.d/wandisco-svn.repo


# install dependent software
RUN yum -y install \
    bzip2 \
    git \
    nodejs \
    nc \
    nmap \
    sendmail \
    subversion mod_dav_svn \
    vim \
    && yum -y update bash \
    && rm -rf /var/cache/yum/* \
    && yum clean all

# Enable and configure xdebug
RUN pecl channel-update pecl.php.net && \
  pecl install xdebug-2.5.5 && \
  pecl install mongo && \
  pecl install pecl.php.net/xhprof-0.9.4

#install bower and gulp
RUN npm install bower -g
RUN npm install gulp -g
RUN npm install nodemon -g
RUN npm install pm2 -g

# temporary switch on the "allow_url_fopen" to install composer and phan
RUN sed -i 's:^allow_url_fopen = Off$:allow_url_fopen = On:g' /etc/php.ini

# installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Our user in the container
USER root

#add vhost config
COPY config/apache2-sites/orangehrm.conf /etc/httpd/sites-available/orangehrm.conf
COPY config/apache2-sites/000-default.conf /etc/httpd/sites-available/000-default.conf
COPY config/cert/orangehrm.crt /etc/apache2/cert/orangehrm.crt
COPY config/cert/orangehrm.key /etc/apache2/cert/orangehrm.key
RUN rm /etc/httpd/sites-enabled/orangehrm.conf
RUN ln -s /etc/httpd/sites-available/orangehrm.conf /etc/httpd/sites-enabled/orangehrm.conf
RUN ln -s /etc/httpd/sites-available/000-default.conf /etc/httpd/sites-enabled/000-default.conf

# set working dir as the installer directory
WORKDIR /var/www/html/installer/

# copy configuration files
COPY config/mysql-client/my.cnf /etc/mysql/my.cnf
COPY config/php.ini /etc/php.ini
COPY config/db-check.sh /var/www/db-check.sh
COPY phpunit-5.7.21.phar /usr/bin/phpunit
RUN  chmod +x /usr/bin/phpunit

# switch off allow_url_fopen
RUN sed -i 's:^allow_url_fopen = On$:allow_url_fopen = Off:g' /etc/php.ini

#CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
