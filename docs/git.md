# Git

```text
Usage:
sajan git [action]

Actions:
clean|c              Reset and clean current git directory
go|g                 Commit all files and push with a default message
relink|rln           Change your remote

Options:
-h     Print this Help.
-e     Explains the command via the dry-run output of the command.
```

### clean 

```Shell
sajan git clean
s git c
```

The active branch is reset to the git index, so all changes are reset. Git add .
will stage all files (that are not listed in the .gitignore) in the entire repository.
Remote changes are pulled into your branch.

### go

```Shell
sajan git go
s git g
```

The git go command stages all changed files. These files are committed with a default sajan commit message via the '
commit' command. After the commit there is a push to your default remote git server.

### relink

```Shell
sajan git relink
s git rln
```
This command will show your current origin name and url and prompt for a new remote and url
