cp -r ./confs-apache2/* /etc/apache2/ 
cp -r /workspaces/eLibrosPHP/site-frontend/ /var/www/html/eLibrosPHP/eLibros.com.br
cp -r /workspaces/eLibrosPHP/site-backend/ /var/www/html/eLibrosPHP/eLibros.backend.biz
service apache2 reload