### Nginx Config For Domain

#### Create Script File
````bash
nano /usr/local/bin/deploy-domain.sh
````

#### deploy-domain.sh
````bash
#!/bin/bash

EMAIL=$1
DOMAIN=$2
WEBROOT="/var/www/shelfcurator/public"
NGINX_PATH="/etc/nginx/sites-available/$DOMAIN"
NGINX_ENABLED="/etc/nginx/sites-enabled/$DOMAIN"

set -e

echo "Creating Nginx config for $DOMAIN..."

sudo tee "$NGINX_PATH" > /dev/null <<EOL
server {
    server_name $DOMAIN www.$DOMAIN;

    root $WEBROOT;
    index index.php index.html;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOL

echo "Enabling site..."
sudo ln -sf "$NGINX_PATH" "$NGINX_ENABLED"

echo "Testing Nginx configuration..."
sudo nginx -t

echo "Reloading Nginx..."
sudo systemctl reload nginx

echo "Issuing SSL certificate..."
sudo certbot --nginx -d $DOMAIN -d www.$DOMAIN --non-interactive --agree-tos --email "$EMAIL" --expand -v
````

#### Make it executable
````bash
sudo chmod +x /usr/local/bin/deploy-domain.sh
````

#### Add command's permission to run from laravel
````bash
sudo visudo
````

````bash
www-data ALL=(ALL) NOPASSWD: /usr/sbin/nginx, /usr/bin/systemctl reload nginx, /usr/bin/certbot, /usr/local/bin/deploy-domain.sh
````

