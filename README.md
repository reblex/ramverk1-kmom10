Ramverk1 - Projekt
==================================

[![Build Status](https://travis-ci.org/reblex/ramverk1-kmom10.svg?branch=master)](https://travis-ci.org/reblex/ramverk1-kmom10)
[![Maintainability](https://api.codeclimate.com/v1/badges/25148125664bf56634bb/maintainability)](https://codeclimate.com/github/reblex/ramverk1-kmom10/maintainability)

Installation
------------------

### First clone the Repo

Clone the repo to a desired location accessible by your web-server, and then move into that directory.

```
$ git clone git@github.com:reblex/ramverk1-kmom10.git
$ cd ramverk1-kmom10
```

### Install and update required tools

Using Make, we can easily install and update all required tools.

```
$ make install
```

### Setup the database configuration

We now need to configure the connection details to our local database. Start by
copying the example config file, and then adjust to local settings.

```
$ rsync -av vendor/reblex/comment/config/database.php config/
```

### Run the SQL setup files

Now just run the SQL-setup files to generate the tables and test data required for
the website to function. You can either use all of the files individually, setting up
one table at a time, or use the handy *all-setup.sql* file which does it all. They
can be found in the *sql/* folder.


Now everything is set up!


License
------------------

This software carries a MIT license.



```
 .  
..:  Copyright (c) 2018 Simon Wahlström (simon.otdw@gmail.com)
```
