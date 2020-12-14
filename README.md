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

````text
Usage:
  sajan [program] [action] [--]
  s     [program] [action] [--]

Actions:
  self-update         Update sajan
  bye                 Deletes sajan

Programs:
  tools               Execute Tools actions
  laravel             Execute Laravel actions
  git                 Execute Git actions
  phpstorm            Execute PhpStorm actions
  webpack             Execute Webpack actions

Options:
  -h     Print this Help.
  -v     Print software version and exit.
  -i     Print software information and exit.

````


### Available command 

[Tools command](docs/tools.md)

[Git command](docs/git.md)

[Laravel command](docs/laravel.md)

[Webpack command](docs/webpack.md)

[PhpStorm command](docs/phpstorm.md)

### Educational role

Sajan provides an educational role , every action has an option to explain the command.
This will show you what the action really does under the hood.

This is an example

````shell
 $ sajan git clean -e
````

````text
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