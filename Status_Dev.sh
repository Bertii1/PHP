#!/bin/bash

# Script per verificare lo stato dell'ambiente APM

echo "=== Stato ambiente APM ==="
echo ""

# Stato PHP
echo "PHP:"
if command -v php &> /dev/null; then
    PHP_VER=$(php -v | head -1)
    echo "  ✓ $PHP_VER"
else
    echo "  ✗ Non installato"
fi

# Stato Apache
echo "Apache:"
if systemctl is-active --quiet apache2; then
    echo "  ✓ Attivo"
    echo "  PID: $(pgrep -x apache2 | head -1)"
else
    echo "  ✗ Non attivo"
fi

# Stato MySQL/MariaDB
echo ""
echo "MySQL/MariaDB:"
if systemctl is-active --quiet mariadb; then
    echo "  ✓ MariaDB attivo"
    echo "  PID: $(pgrep -x mariadbd | head -1)"
elif systemctl is-active --quiet mysql; then
    echo "  ✓ MySQL attivo"
    echo "  PID: $(pgrep -x mysqld | head -1)"
else
    echo "  ✗ Non attivo"
fi

# Porte in ascolto
echo ""
echo "Porte in ascolto:"
ss -tlnp 2>/dev/null | grep -E ':(80|3306)\s' | awk '{print "  " $4}' || echo "  Nessuna porta rilevata"

echo ""
