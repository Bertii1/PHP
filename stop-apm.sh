#!/bin/bash

# Script per fermare l'ambiente di sviluppo APM

set -e

echo "=== Arresto ambiente APM ==="

# Ferma Apache
echo "Arresto Apache..."
sudo systemctl stop apache2 2>/dev/null && echo "  Apache fermato" || echo "  Apache non era in esecuzione"

# Ferma MySQL/MariaDB
echo "Arresto MySQL/MariaDB..."
if systemctl is-active --quiet mariadb 2>/dev/null; then
    sudo systemctl stop mariadb
    echo "  MariaDB fermato"
elif systemctl is-active --quiet mysql 2>/dev/null; then
    sudo systemctl stop mysql
    echo "  MySQL fermato"
else
    echo "  MySQL/MariaDB non era in esecuzione"
fi

echo ""
echo "=== Ambiente APM fermato ==="
