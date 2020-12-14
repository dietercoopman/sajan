# sajan

Sajan is a lightweight command line tool for webdevelopers , the aim is to automate some multiline commands

## Requirements

Sajan is tested on MacOs.
Sajan uses tools like git , npm , node , composer. For us brew is the best tool to install
these so we require brew. If you dont have it you can install it via sajan.

## Installation

````shell
curl -s https://www.deltasolutions.be/sajan/ | bash
````

## Available commands

Sajan is a work in progress , this is the first release. Documentation will be provided soon. The tool has a help
function for every command where the available commands are listed.


### Sajan 

````shell
sajan self-update         # Update sajan
sajan tools-check         # Check if all tools needed for sajan are present
sajan tools-update        # Update tools used by sajan
sajan tools-install       # Install the tools used by sajan
````

### Laravel 

````shell
sajan laravel install (version) (folder)  # install new laravel version in folder
sajan laravel update                      # update laravel
````

### Git 

````shell
sajan git clean   # reset and cleanup git 
sajan git go      # commit and push your changes
````

### PhpStorm

````shell
sajan phpstorm open    # open phpstorm with current folder open
````

### Webpack 

````shell
sajan webpack build       # build your webpack assets
sajan webpack init        # bootstrap a webpack setup in current folder
````
