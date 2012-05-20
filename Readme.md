Mahok/JbTools
=============

JbTools is a set of administrative tools for the command line for working with
Juicebox-gallery.

For more information on Juicebox and SimpleViewer see:

http://juicebox.net
 http://simpleviewer.net

Implemented commands:
---------------------

    jb:import

Takes a folder containing a SimpleViewer2-gallery or multiple galleries and
imports data into a config.xml required for Juicebox.

As of now nothing is moved or changed. Only the additional config.xml will be
created!

Planned commands:
-----------------

    jb:cleanup

Removes old data from SimpleViewer2 from each imported folder, i.e. each folder
containing a config.xml.

    jb:update

Looks whether the gallery-folder contains new images and adds them to the
config.xml.

Installation instructions
-------------------------

1.) Either download or clone repository.

2.) Download composer.phar (see composer/composer)

3.) Run ```php composer.phar install```

Requirements
------------

    PHP >= 5.3.3

How to work with JbTools
------------------------

For help check Symfony's documentation on Symfony\Component\Console:

http://symfony.com/doc/master/components/console.html