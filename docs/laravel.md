# Laravel

```text
Usage:
  sajan laravel [action]
  s laravel [action]

Actions:
  install|i [version] [folder]            Install a specific laravel version in a given folder

Options:
  -h     Print this Help.
  -e     Explains the command via the dry-run output of the command.
```

### install 

```Shell
sajan laravel install [version] [folder]
s laravel i [version] [folder]
```

This command first checks if a version is given, if not a list of all available version is fetched from the internet.
If a version is provided and the given folder exists then the scripts prompts for deletion of the folder by the user.
If all parameters are set the specified Laravel version is pulled from the internet.
The scripts cd's into th folder and installs laravel, fetches the laravel version via artisan and returns a success
message
