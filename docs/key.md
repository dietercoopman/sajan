# Key


````text

Usage:
   sajan key [action]
   s key [action]

  
  Actions:
    copy|c             ${NC}Read the public key of a key pair"
    dir|d              ${NC}Cd into your ssh key folder"
    make|m             ${NC}Create a ssh key"
    push|p             ${NC}Push a provided ssh key to a given ssh server"
  
  Options:
    -h     Print this Help.
    -e     Explains the command via the dry-run output of the command.
  
  
````

### copy 

```Shell
  sajan key copy
  s key c
```
This command will prompt you which key you want to copy , when selected the specified key will be copied to
the clipboard 

### dir 

```Shell
 sajan key dir
 s key d
```
This command will cd you into your key keys folder

### make

```Shell
 sajan key make
 s key m
```
This command will create a new key key

### make

```Shell
 sajan key push
 s key p
```
This command will push a provided ssh key to an ssh server
