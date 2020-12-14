# sajan

Sajan is a lightweight command line tool for webdevelopers.  The tools provides developers with shortcuts for multiline
commands.  

## Requirements

Sajan is a shell tool tested on MacOs and Linux

Sajan uses tools like git , npm , node , composer. 
For us brew is the best tool to install these programs , so we depend on it. If you dont have it you can install it via sajan.

## Installation

````shell
curl -s https://www.deltasolutions.be/sajan/ | bash
````

## Available commands

````shell
Usage:
  sajan [program] [action] [--]
  s     [program] [action] [--]

Actions:
  self-update         Update sajan
  bye                 Deletes sajan
  tools-check         Check if all tools needed for sajan are present
  tools-update        Update tools used by sajan
  tools-install       Install the tools used by sajan

Programs:
  laravel             Execute Laravel actions
  git                 Execute Git actions
  phpstorm            Execute PhpStorm actions
  webpack             Execute Webpack actions

Options:
  -h     Print this Help.
  -v     Print software version and exit.
  -i     Print software information and exit.

````


### Available programs 

[Git - actions](docs/git.md)

[Laravel documentation](docs/laravel.md)

[Webpack actions](docs/webpack.md)

[PhpStorm actions](docs/phpstorm.md)

### Educational role

Sajan provides an educational role , every action has an option to explain the command.
This will show you what the action really does under the hood.

This is an example

````shell
  sajan git clean
  s git c

  This command will execute the following commands

  git reset --hard
  git add .
  git pull

  The active branch is reset to the git index, so all changes are reset. Git add .
  will stage all files (that are not listed in the .gitignore) in the entire repository.
  Remote changes are pulled into your branch.

  Used tools for this action:
  - git
````