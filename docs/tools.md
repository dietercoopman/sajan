# Tools

```text
Usage:
  sajan tools [action]

Actions:
  install       Install the tools used by sajan
  update        Update tools used by sajan
  check         Check if all tools needed for sajan are present

Options:
  -h     Print this Help.
  -e     Explains the command via the dry-run output of the command.
```

### install 

```Shell
sajan tools install
s tools i
```

This program first asks the user confirmation to install brew itself.  After this installation
npm, node, git and composer are installed via brew.

### update

```Shell
sajan tools update
s tools u
```

This program will upgrade all installed brew packages.

### check

```Shell
sajan tools check
s tools c
```

This command checks the version of all the uses programs to see if they are installed

