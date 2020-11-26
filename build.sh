#!/bin/sh
echo "[+] Checking if .env file is configured..."
[ -f ".env" ] || { echo "[!] File does not exists! Please copy the data from .env.example and change it!"; exit; }
[ $(stat -c %a src) = 775 ] || { 
echo "[+] Setting up the permissions! We will need sudo access."
sudo chown -R $(echo $USER):http ./src
sudo chmod -R 775 ./src
}
echo "[+] Permissions set."
echo "[+] Checking if composer is installed..."
[ -f "/usr/bin/composer" ] || {
    echo "[-] It seems it doesn't exists. We will install it quickly";
    curl -sS https://getcomposer.org/installer | php -- --install-dir=. --filename=composer
}
echo "[+] Installing composer dependencies"
composer install -d src
echo "[+] Dependencies installed successfully"
[ -f "composer" ] && { rm composer; echo "[+] Removed previous installed composer."; }
echo "[+] Starting the docker container" 
docker-compose up -d --build