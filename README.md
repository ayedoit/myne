![myne](https://raw.github.com/ayedoit/myne/master/img/myne_logo.png)

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


Maintainer
----------

[Fabian Peter](mailto:hello@fabianpeter.de) | [ayedo IT Solutions](http://www.ayedo.de/)

