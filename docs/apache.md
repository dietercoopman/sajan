# Apache


````text
Usage:
  sajan apache [action]

Actions:
  list|l [site]            List all active sites on your system, you can optionaly pass a site to search for
  inspect|i [uniqueid]     Get more details for a given site , like vhost , source path, application type, database


Options
-h     Print this Help.
-e     Explains the command via the dry-run output of the command.
````

### list 

```Shell
  sajan apache list [site]
  s apache l
```

This command lists all the configured apache sites and show you the url of the site, the configuration file the site is located ( include line number ).
It will provide you a identifier that can be used in other sajan apache commands.

#### example output

````shell
Hostname                  Configuration file                                    Unique id
https://sajan.app         /etc/apache2/sites-enabled/sajan.conf:3               98dfbcc154c472e562e053290f3c6ecf
````

### inspect 

```Shell
 sajan apache inspect [uniqueid]
 s apache i [uniqueid]
```

This command retreives the site with the unique id ( as shown in the 'sajan apache list command'
The command returns you site information, the url, the apache config file and line in that file, the document root.

#### example output

````shell
Site type: Wordpress site
Url: https://sajan.app
Apache config file: /etc/apache2/sites-enabled/sajan.conf
Config on line: 3
Document root:  /var/www/sajan
````