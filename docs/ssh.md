# Apache


````text

Usage:
   sajan ssh [action]
   s ssh [action]

  
  Actions:
    copykey|c             ${NC}Read the public key of a key pair"
    dir|d                 ${NC}Cd into your ssh folder"
    makekey|m             ${NC}Create an ssh key"
  
  Options:
    -h     Print this Help.
    -e     Explains the command via the dry-run output of the command.
  
  
````

### copykey 

```Shell
  sajan ssh copykey
  s ssh c
```
This command will prompt you which key you want to copy , when selected the specified key will be copied to
the clipboard 

### dir 

```Shell
 sajan ssh dir
 s ssh d
```
This command will cd you into your ssh keys folder

### makekey

```Shell
 sajan ssh makekey
 s ssh m
```
This command will create a new ssh key
