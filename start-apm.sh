#!/bin/bash

# Script per avviare l'ambiente di sviluppo APM
# Directory di lavoro: /home/filippo/Progetti/PHP

set -e

WORK_DIR="/home/filippo/Progetti/PHP"
VHOST_CONF="/etc/apache2/sites-available/dev-php.conf"

echo "=== Avvio ambiente APM ==="

# Verifica che la directory esista
if [ ! -d "$WORK_DIR" ]; then
    echo "Errore: La directory $WORK_DIR non esiste"
    exit 1
fi

# Imposta permessi per Apache (www-data)
echo "Impostazione permessi..."
chmod o+x /home/filippo
chmod o+x /home/filippo/Progetti
chmod -R o+rx "$WORK_DIR"

# Verifica che PHP sia installato
PHP_VERSION=$(php -v 2>/dev/null | head -1 | grep -oP 'PHP \K[0-9]+\.[0-9]+' || echo "")
if [ -z "$PHP_VERSION" ]; then
    echo "Errore: PHP non è installato"
    echo "Installa con: sudo apt install php libapache2-mod-php php-mysql"
    exit 1
fi
echo "PHP versione $PHP_VERSION rilevato"

# Crea configurazione VirtualHost se non esiste
if [ ! -f "$VHOST_CONF" ]; then
    echo "Creazione VirtualHost per $WORK_DIR..."
    sudo tee "$VHOST_CONF" > /dev/null <<EOF
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot $WORK_DIR
    DirectoryIndex index.php index.html

    <Directory $WORK_DIR>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted

        # Directory Listing avanzato
        IndexOptions FancyIndexing HTMLTable SuppressDescription
        IndexOptions VersionSort FoldersFirst NameWidth=*
        IndexOrderDefault Ascending Name
    </Directory>

    <FilesMatch \.php$>
        SetHandler application/x-httpd-php
    </FilesMatch>

    ErrorLog \${APACHE_LOG_DIR}/dev-php-error.log
    CustomLog \${APACHE_LOG_DIR}/dev-php-access.log combined
</VirtualHost>
EOF
fi

# Disabilita il sito di default
echo "Disabilitazione sito di default..."
sudo a2dissite 000-default.conf > /dev/null 2>&1 || true

# Abilita moduli necessari
echo "Abilitazione moduli Apache..."
sudo a2enmod rewrite > /dev/null 2>&1 || true
sudo a2enmod autoindex > /dev/null 2>&1 || true

# Abilita modulo PHP (cerca la versione corretta)
PHP_MOD=$(ls /etc/apache2/mods-available/ 2>/dev/null | grep -E "^php[0-9]+\.[0-9]+\.load$" | sed 's/\.load$//' | head -1)
if [ -n "$PHP_MOD" ]; then
    sudo a2enmod "$PHP_MOD" > /dev/null 2>&1 || true
    echo "  Modulo $PHP_MOD abilitato"
else
    echo "  Attenzione: modulo PHP per Apache non trovato"
    echo "  Installa con: sudo apt install libapache2-mod-php"
fi

# Abilita il sito
echo "Abilitazione VirtualHost..."
sudo a2ensite dev-php.conf > /dev/null 2>&1 || true

# Avvia MySQL/MariaDB
echo "Avvio MySQL/MariaDB..."
if systemctl list-units --type=service | grep -q mariadb; then
    sudo systemctl start mariadb
    echo "  MariaDB avviato"
elif systemctl list-units --type=service | grep -q mysql; then
    sudo systemctl start mysql
    echo "  MySQL avviato"
else
    echo "  Attenzione: MySQL/MariaDB non trovato"
fi

# Avvia Apache
echo "Avvio Apache..."
sudo systemctl start apache2
echo "  Apache avviato"

echo ""
echo "=== Ambiente APM attivo ==="
echo "URL: http://localhost"
echo "DocumentRoot: $WORK_DIR"
echo ""
echo "Per fermare l'ambiente: ./stop-apm.sh"
