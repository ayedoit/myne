![myne](https://raw.github.com/ayedoit/myne/master/img/myne_logo.png)

ACHTUNG
=======

Wir suchen Android-Entwickler, die Interesse haben, für **myne** eine Android-App zu entwickeln. Für Infos, mailt einfach kurz an [hello@fabianpeter.de](mailto:hello@fabianpeter.de).

Updaten
=======

Wenn **myne** schon installiert habt, reicht es, die Sourcen zu updaten (git pull). **myne** wird merken, ob es Unterschiede in der Version der Sourcen und der Datenbank gibt und euch den Update aufrufen.

Idealerweise macht ihr natürlich vor jedem Update eine Sicherung eurer Datenbak & des Codes.

Installieren
============

Voraussetzungen
---------------
* Webserver (Apache, nginx)
* MySQL Server + fertige Datenbank (UTF-8)
* curl & php5-curl
* 433 MHz Gateway ([ConnAir](http://simple-solutions.de/shop/product_info.php?products_id=87))
* Für Tasks: eine Cron-Funktion auf dem Server

Download
--------
```bash
cd /var/www
wget https://github.com/ayedoit/myne/archive/master.zip
unzip master.zip
mv myne-master myne
```

Oder

```bash
cd /var/www
git clone git://github.com/ayedoit/myne.git
```

Datenbank-Setup
---------------
Ihr müsst die Datenbank vorher anlegen (zB via phpmyadmin). Die Zugangsdaten zu eurer Datenbank müssen in **/var/www/myne/myne/config/database.php** eingetragen werden.

```php
$db['default']['hostname'] = 'DB-HOST';
$db['default']['username'] = 'DB-USER';
$db['default']['password'] = 'DB-PASSWORT';
$db['default']['database'] = 'DB';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
```

Webserver-Setup
---------------
**myne** benutzt eine ```.htaccess``` Datei für das Rewriting der URLs. Damit diese funktioniert, muss im vHost folgendes angepasst werden:

**Apache**

```bash
<Directory /var/www/myne>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
</Directory>
```
Wichtig ist der Part "AllowOverride All".

Zusätzlich muss natürlich **mod_rewrite** aktiviert werden.

```bash
a2enmod rewrite
service apache2 restart
```

**Beispiel vHost**

**vHost anlegen**

```bash
cd /etc/init.d/apache2/sites-available
nano myne
```

**vHost Config**

```bash
<VirtualHost *:80>

        DocumentRoot /var/www/myne
        <Directory />
                Options FollowSymLinks
                AllowOverride None
        </Directory>
        <Directory /var/www/myne>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
        </Directory>

        ScriptAlias /cgi-bin/ /usr/lib/cgi-bin/
        <Directory "/usr/lib/cgi-bin">
                AllowOverride None
                Options +ExecCGI -MultiViews +SymLinksIfOwnerMatch
                Order allow,deny
                Allow from all
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/myne.error.log

        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn

        CustomLog ${APACHE_LOG_DIR}/myne.access.log combined
</VirtualHost>
```

**vHost aktivieren**:

```bash
a2ensite myne
service apache2 restart
```

Der Installer
-------------
Wenn eure Datenbank-Zugangsdaten eingetragen sind und euer Webserver richtig konfiguriert ist (das überlasse ich mal jedem selbst, da man dafür kein Allgemeinrezept hierhin packen kann), dann ruft den Installer auf: 

```html
http://MYNE-HOST/installer
```

Dort müsst ihr eure Userdaten hinterlegen, für den Fall, dass ihr später **myne** mit Login benutzen wollt (bietet aktuell nur Schutz vor ungewolltem Zugriff - ACLs folgen später). Der Installer legt euch die nötigen Tabellen an.

Erste Schritte
--------------
Aktuell können **nur Funksteckdosen** auf 433 MHz Basis gesteuert werden. Die Steuerung von XBMC-Hosts ist zwar implementiert, braucht aber noch Feinschliff.

Daher würde es sich anbieten, eure ersten Schritte mit **myne** so zu beginnen:

* Räume > Raum anlegen (jedes Gerät steht in einem Raum. Logisch, oder? Und ja - auch der Garten wäre hier ein Raum.)
* Gateways > Gateway anlegen (Ohne Gateway - bzw. ohne [ConnAir](http://simple-solutions.de/shop/product_info.php?products_id=87) - könnt ihr die Funksteckdosen nicht steuern)
* Geräte > Gerät anlegen

Ihr könnt Räume, Gruppen und Geräte auch im "Gerät anlegen" Dialog mitanlegen, wenn euch das einfacher erscheint.

WIP
---
* Tasks für Gruppen/Räume/Gerätetypen können ebenfalls festgelegt werden, allerdings gibt es auch dafür keine Frontendfunktion
* Der übliche Feinschliff im Frontend

Bug-Reports & Feature-Requests
------------------------------
Bitte nutzt dafür die [GitHub Issues](https://github.com/ayedoit/myne/issues). Sollte es wirklich dringend sein oder ihr Bock auf Fachsimpeleien habt, mailt mir an [hello@fabianpeter.de](mailto:hello@fabianpeter.de)

myne ist
========

ein Home Automation Gateway
---------------------------
[myne](http://myne.ayedo.de/) ist ein Server der als Schnittstelle zwischen verschiedenen steuerbaren Geräten in deinem Haushalt dient. Grundsätzlich sind der Phantasie da keine Grenzen gesetzt - lediglich unserer Zeit und unseren Mitteln, alles mögliche auszuprobieren.

freie Open Source Software
--------------------------
Jeder Nerd da draußen möchte seine Elektrik fernsteuern können. Grundsätzlich kann das jeder. Aber die meisten "guten" und "einfachen" Lösungen (betrachten wir das mal als logisches AND) sind auch teuer und/oder proprietär.

Wir meinen: Das muss so nicht sein. **myne** bietet eine gute Basis, neue Module zu entwickeln und mehr und mehr Geräte und Gerätetypen steuern zu können. Mit eurer Hilfe sollte das möglich sein.

kein Cloud-Dienst
-----------------
Zur Installation und Benutzung benötigst du zuhause einen Web- und einen MySQL-Server. Natürlich kannst du **myne** auch extern hosten, die Steuerung der Geräte in deinem Zuhause wird dann aber entsprechend komplex.

keine Standalone-Applikation
----------------------------
Man kann natürlich keine Software installieren und plötzlich alle Lichtschalter durch Magie am PC an- und ausschalten.

Du brauchst steuerbare Aktoren, wie z.B. **Funksteckdosen** für deine Elektrogeräte, **Funkmodule** für den Unterputz-Einbau oder die Steuerung von Rolläden.

Für die Steuerung von Funk-Geräten (433 MHz Devices) brauchst du ein Gateway. **myne** funktioniert hervorragend mit dem [ConnAir](http://simple-solutions.de/shop/product_info.php?products_id=87).

Aktuell kannst du auch dein XBMC an- und ausschalten. Allerdings ist das noch WIP und nicht sehr zuverlässig. Wir arbeiten daran.

myne kann
=========

* Funksteckdosen
* Funkschalter
* Mediencenter-Software (z.B. XBMC)
 
von Herstellern wie z.B.
------------------------

* Intertechno
* Elro
* Brennenstuhl
* Pollin
* Dario (DMV-7008)
* vermutlich vielen mehr - **da ist es an euch, zu testen**

eine offene API
---------------
Eine **JSON-RPC API** bildet jede Funktion des Backends transparent ab. Das bietet natürlich Möglichkeiten, eigene mobile Apps zu programmieren. Dokumentation folgt. 

myne wird können
================

* elektrischen Rolläden
* Kameras
* Bewegungssensoren
* Wetterinformationen
* Heizungsthermostate
* WLAN Steckdosen

myne könnte
===========
Vermutlich vieles. Theoretisch sind WeMos von Belkin steuerbar, ebenso Homematic Geräte und zahlreiche vorhandene WLAN Steckdosen-Aufsätze. Aktuell ist **myne** WIP und geht steil auf die erste Final zu. Wir versuchen möglichst viele Geräte in die Finger zu kriegen, um sie ins System zu bringen. Gebt uns Zeit. Oder **macht es selbst**.

Lizenz
======

**myne** ist unter der **GNU GENERAL PUBLIC LICENSE v3** veröffentlicht. Wem das nichts sagt: [TL;DRLegal](http://www.tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)

Maintainer
----------

[Fabian Peter](mailto:hello@fabianpeter.de) | [ayedo IT Solutions](http://www.ayedo.de/)

