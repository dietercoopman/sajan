# sajan

![Sajan](brand/sajjan.png?raw=true "Sajan")

Sajan is a lightweight command line tool for webdevelopers.  

The tool provides them with shortcuts for multiline commands or opens a world of hidden oneliners.

## Requirements

Sajan is a shell tool tested on MacOs desktop and Linux servers

Sajan uses tools like brew, git, npm, node and composer. 

For us brew is the best tool to install these programs, so we depend on it. If you don't have it, you can install it easily via sajan.

## Installation

The purpose of sajan is simplicity, and that starts with the installation ... 

````shell
curl -s https://www.deltasolutions.be/sajan/ | bash
````

## Welcome

One sajan is installed you can get an overview of all the commands by running the `sajan` command.  You will see this 
welcome screen.

![Sajan home screen](brand/overview.png?raw=true "Sajan home screen")


## Available commands

````text
Usage:
  sajan [program] [action] [--]
  s     [program] [action] [--]

Actions:
  self-update         Update sajan
  bye                 Delete sajan
  alias               Create an alias for a program or command
  aliases             Show all aliases on your system

Programs:
 
  apache              Execute Apache actions
  git                 Execute Git actions
  laravel             Execute Laravel actions
  phpstorm            Execute PhpStorm actions
  ssh                 Execute Ssh actions
  tools               Execute Tools actions
  webpack             Execute Webpack actions

Options:
  -h     Print this Help.
  -v     Print software version and exit.
  -i     Print software information and exit.

````


### Available command 

[Apache command](docs/apache.md)

[Git command](docs/git.md)

[Laravel command](docs/laravel.md)

[PhpStorm command](docs/phpstorm.md)

[Ssh command](docs/ssh.md)

[Tools command](docs/tools.md)

[Webpack command](docs/webpack.md)

### Cheatsheet

[I've build a cheatsheet , it can be found here](docs/cheatsheet.md)

### Educational purpose

One of my personal goals is to provide developers with knowledge. Sajan provides an educational purpose. Every action has an option to explain the command ( -e ).
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
