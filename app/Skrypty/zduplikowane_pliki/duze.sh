#!/bin/bash

# Przenieś 5 największych plików do folderu "jakiskatalog"

mv `ls -S | head -5` /jakiskatalog

# Przenieś i zlinkuj
# Przenieś 50 największych plików do katalogu ....attachments/skp2
# A następnie zlinkuj wszystkiete pliki do katalogu, gdzie SKP ma pliki (tak ze nadal będę dostępne)

mv `ls -S | head -50` /var/www/forum.lan/attachments/skp2

ln -s /var/www/forum.lan/attachments/skp2/* /var/www/skp/skp.lan/public_html/app/uploads