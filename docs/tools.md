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

This program first asks the user confirmation to install brew itself.  After this installation
npm, node, git and composer are installed via brew.

### update

This program will upgrade all installed brew packages.

### check

This command checks the version of all the uses programs to see if they are installed

