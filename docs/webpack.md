# Webpack

```text
Usage:
  sajan webpack [action]
  s webpack [action]

Actions:
  init|i              Init webpack for css and javascript in current directory
  build|i             Build your assets

Options:
  -h     Print this Help.
  -e     Explains the command via the dry-run output of the command.
```

### init 

A configuration json for npm is saved to package.json. This file contains all necessary packages to install.
A sass directory is created with a style.scss file.
A webpack configuration file is created , this contains all webpack settings.
Npm install will install all packages provided in package.json
A build process is started to create the assets.


### build

Install npm packages.  Build all assets
