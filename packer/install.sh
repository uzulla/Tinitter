#!/bin/sh

## OS setup

sudo yum -y update
sudo cp /etc/localtime /etc/localtime.org && \
    sudo cp -p /usr/share/zoneinfo/Japan /etc/localtime


## PHP 5.6 install

sudo yum install -y php56 php56-pdo php56-mbstring
sudo cp /etc/php.ini /etc/php.ini.orig
sudo sed -i 's/;internal_encoding =/internal_encoding = UTF-8/g' /etc/php.ini
sudo sed -i 's@;date.timezone =@date.timezone = "Asia/Tokyo"@g' /etc/php.ini


## Apache setttings

#sudo mkdir -p /Tinitter/htdocs

sudo rm -rf /etc/httpd/conf.d/welcome.conf
cat <<EOL >> tinitter.conf
<VirtualHost *:80>
    DocumentRoot "/Tinitter/htdocs"
    <Directory "/Tinitter/htdocs">
        AllowOverride All
        Options All
        Require all granted
    </Directory>
</VirtualHost>
EOL
sudo mv tinitter.conf /etc/httpd/conf.d/tinitter.conf 

sudo service httpd start
sudo chkconfig httpd on

## CodeDeploy Agent install
## (plz be last)

wget https://aws-codedeploy-ap-northeast-1.s3.amazonaws.com/latest/install
chmod +x ./install
sudo ./install auto

