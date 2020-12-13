#!/bin/bash
declare BRANDCOLOR='\033[0;33m'
declare INFOCOLOR='\033[0;36m'
declare ERRORCOLOR='\033[1;101m'
declare LOVECOLOR='\033[31m'

declare GREEN='\033[0;32m'
declare YELLOW='\033[0;33m'
declare NC='\033[0m'
declare VERSION=0.12-alfa

################################################################################
# VERSION                                                                      #
################################################################################

Version() {
  echo -e "${GREEN}Sajan${NC} version ${YELLOW}$VERSION${NC} by Dieter Coopman"
}

################################################################################
# Help                                                                         #
################################################################################

Help() {
  # Display Help
  echo -e "
${YELLOW}Usage:${NC}"
  echo "  sajan [program] [action] [--]"
  echo "  s     [program] [action] [--]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}self-update         ${NC}Update sajan"
  echo -e "  ${GREEN}bye                 ${NC}Deletes sajan"
  echo -e "  ${GREEN}tools-check         ${NC}Check if all tools needed for sajan are present"
  echo -e "  ${GREEN}tools-update        ${NC}Update tools used by sajan"
  echo -e "  ${GREEN}tools-install       ${NC}Install the tools used by sajan"

  echo
  echo -e "${YELLOW}Programs:"
  echo -e "  ${GREEN}laravel             ${NC}Execute Laravel actions"
  echo -e "  ${GREEN}git                 ${NC}Execute Git actions"
  echo -e "  ${GREEN}phpstorm            ${NC}Execute PhpStorm actions"
  echo -e "  ${GREEN}webpack             ${NC}Execute Webpack actions"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-v     Print software version and exit."
  echo -e "  ${GREEN}-i     Print software information and exit."
  echo
  echo
}

################################################################################
# Info                                                                         #
################################################################################

Info() {
  echo -e "${BRANDCOLOR}
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
           JJJJJJJ       JJJJJJJ JJJJJJJ       JJJJJJJ
           JJJJJJJ       JJJJJJJ JJJJJJJ       JJJJJJJ
           JJJJJJJ       JJJJJJJ JJJJJJJ       JJJJJJJ
            JJJJJJJ      JJJJJJJ JJJJJJJJ     JJJJJJJJ
            JJJJJJJJJJJJJJJJJJJ   JJJJJJJJJJJJJJJJJJJ
              JJJJJJJJJJJJJJJ       JJJJJJJJJJJJJJJ
            JJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJ
            JJJJJJJJJJASPERJJJJJJJJJJJJANAJJJJJJJJJJJ
            JJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJ
${NC}
${GREEN}Sajan${NC} is a lightweight tool to automize some web development tasks
This tool provides you with some automation tasks for Laravel, Git, PhpStorm and Webpack
"

}

sajan_self-update() {
  curl -s https://raw.githubusercontent.com/dietercoopman/sajan/master/bin/sajan -o sajan
  mv sajan /usr/local/bin
  chmod +x /usr/local/bin/sajan
  ln -s /usr/local/bin/sajan /usr/local/bin/s
  echo -e "${GREEN}Sajan${NC} has been updated to version ${YELLOW}$VERSION${NC}"
  exit
}

sajan_brew_test() {
  if ! brew --version >/dev/null 2>&1; then
    echo -e "${RED}Brew is not installed on your computer"
    return 0
  else
    echo -e "${INFOCOLOR}Brew is found on your computer"
    return 1
  fi
}

sajan_tools-check() {
  sajan_brew_test
  BREWOK=$?
  sajan_git_test
  GITOK=$?
  sajan_laravel_test
  LARAVELOK=$?
  sajan_phpstorm_test
  PHPSTORMOK=$?
  sajan_webpack_test
  WEBPACKOK=$?

  ALLOK=$(($BREWOK + $GITOK + $LARAVELOK + $PHPSTORMOK + $WEBPACKOK))

  if [[ $ALLOK == 5 ]]; then
    echo -e "${GREEN}All tools are set , enjoy sajan !"
  else
    echo -e "${ERRORCOLOR}Not all tools are set , review the red lines "
  fi
}

sajan_tools-update() {
  echo -e "${INFOCOLOR}Start updating toolset , brew , npm , git , node "
  brew upgrade
  npm update -g
  echo -e "${GREEN}All tools are updated , enjoy using sajan !"
}

sajan_tools-install() {
  echo -e "${INFOCOLOR}Installing sayan toolset , brew , node , npm , git , composer "
  /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
  brew install npm
  brew install node
  brew install git
  brew install composer
  echo -e "${GREEN}All tools are installed , enjoy using sajan !"
}

sajan_bye() {
  # clear sessions
  echo -e "
  ${INFOCOLOR}I hope you mistyped ;-) ...
  Are you sure you want to delete sajan (y/n)? ${NC}\c"
  read sure
  case "$sure" in
  'y')

    echo "
  I'm sorry to see you leaving ... Bye Bye !! I am allready self-destroying ..."
    rm /usr/local/bin/s
    rm /usr/local/bin/sajan
    echo "
  And now I'm gone ... :( I'll prove with an error :(
   "
  sajan -v
    ;;
  *)
    echo -e "${NC}
  I love you tooooo ${LOVECOLOR}♥♥♥♥${NC} ... I'll do a self test ... Am i still here ???
  "
      sajan -v
  echo "
  Pfieeuw ... "

    ;;
  esac
  echo -e ''
}
################################################################################
# Git                                                                          #
################################################################################

sajan_git() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  clean|c)
    sajan_git_clean
    exit
    ;;
  go|g)
    sajan_git_go
    exit
    ;;
  *)
    sajan_git_help
    exit
    ;;
  esac

}

################################################################################
# Test                                                                         #
################################################################################

sajan_git_test() {
  if ! git --version >/dev/null 2>&1; then
    echo -e "${RED}Git is not installed on your computer"
    return 0
  else
    echo -e "${INFOCOLOR}Git is found on your computer"
    return 1
  fi
}

################################################################################
# Help                                                                         #
################################################################################

sajan_git_help() {
  # Display Help
  echo -e "
${YELLOW}Usage:${NC}"
  echo "  sajan git [action]"

  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}clean|c             ${NC}Reset and clean current git directory"
  echo -e "  ${GREEN}g|g                 ${NC}Commit all files and push with a default message"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-e     Explains the command via the dry-run output of the command."
  echo
  echo
}
################################################################################
# Clean                                                                        #
################################################################################

sajan_git_clean() {
  OPTION="${OPTIONS['h']}"

  if [ "$OPTION" = "h" ]; then
    sajan_git_clean_help
  fi

  if [ "$OPTION" = "e" ]; then
    sajan_git_clean_explain
  fi

  git reset --hard
  git add .
  git pull
}

################################################################################
# Help                                                                        #
################################################################################

sajan_git_clean_help() {
  echo -e "
  ${GREEN}clean|c              ${NC}Reset and clean current git directory
  "
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_git_clean_explain() {
  echo -e "
  ${GREEN}sajan git clean
  ${GREEN}s git c

  This command will execute the following commands${NC}

  git reset --hard
  git add .
  git pull"
  echo -e "
  ${YELLOW}The active branch is reset to the git index, so all changes are reset. Git add .
  will stage all files (that are not listed in the .gitignore) in the entire repository.
  Remote changes are pulled into your branch.${NC}

  Used tools for this action:
  - git

  "
  exit
}
################################################################################
# GO                                                                        #
################################################################################

sajan_git_go() {
  SAJANTIME=$(date +"%m-%d-%Y %H:%M")
  OPTION="${OPTIONS['h']}"

  if [ "$OPTION" = "h" ]; then
    sajan_git_go_help
  fi

  if [ "$OPTION" = "e" ]; then
    sajan_git_go_explain
  fi

  SAJANTIME=$(date +"%m-%d-%Y %H:%M")
  git add .
  git commit -m "sajan push at ${SAJANTIME}"
  git push
}

################################################################################
# Help                                                                        #
################################################################################

sajan_git_go_help() {
  echo -e "
  ${GREEN}go|g                 ${NC}Commit all files and push with a default message"
  echo -e "  ${INFOCOLOR}This action will stash all your files , commit them with a default message and push them to the default remote
  "
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_git_go_explain() {
  echo -e "
  ${GREEN}sajan git go
  ${GREEN}s git g

  This command will execute the following commands${NC}

  git add .
  git commit -m "sajan push at ${SAJANTIME}"
  git push

  ${YELLOW}The git add stages all changed files. These files are committed with a default sajan commit
  message via the 'commit' command.  After the commit there is a push to your default remote git server.${NC}

  Used tools for this action:
  - git

  "
  exit
}
################################################################################
# Laravel                                                                      #
################################################################################

sajan_laravel() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  install|i)
    sajan_laravel_install $3 $4
    exit
    ;;
  *)
    sajan_laravel_help
    exit
    ;;
  esac
}

################################################################################
# Test                                                                         #
################################################################################

sajan_laravel_test() {
  if ! composer -V >/dev/null 2>&1; then
    echo -e "${RED}Composer is not installed on your computer"
    return 0
  else
    echo -e "${INFOCOLOR}Composer is found on your computer"
    return 1
  fi
}

################################################################################
# Help                                                                         #
################################################################################

sajan_laravel_help() {
  # Display Help
  echo -e "
${YELLOW}Usage:${NC}"
  echo "  sajan laravel [action]"
  echo "  s laravel [action]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}install|i             ${NC}Install a specific laravel version in a given folder"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo
  echo
}

################################################################################
# Install                                                                      #
################################################################################

sajan_laravel_install() {
  local VERSION="$1"
  local FOLDER="$2"

  OPTION="${OPTIONS['h']}"

  if [ "$OPTION" = "h" ]; then
    sajan_laravel_install_help
  fi

  if [ "$OPTION" = "e" ]; then
    sajan_laravel_install_explain
  fi

  if [[ $VERSION == "" ]]; then
    echo -e "${ERRORCOLOR}Please provide a version , choose one from ${NC}"
    git ls-remote --heads https://github.com/laravel/laravel.git | cut -f 2 | cut -b 12-20
    exit
  fi

  if [[ -d "$FOLDER" ]]; then
    echo -e "${ERRORCOLLOR}Folder {$FOLDER} allready exits ... Please remove it first ${NC}"
    exit
  fi

  echo -e "${INFOCOLOR}Start installation of laravel ${VERSION} into folder ${FOLDER} ${NC}"
  git clone --branch ${VERSION} https://github.com/laravel/laravel.git ${FOLDER}
  cd $FOLDER
  composer install

  VERSION="$(php artisan -V)"
  PERSON="$(whoami)"
  echo -e "${INFOCOLOR}Congratulations ${PERSON} you sucessfully installed ${VERSION} into folder ${FOLDER} ${NC}"

}
################################################################################
# Help                                                                        #
################################################################################

sajan_laravel_install_help() {
  echo -e "
  ${GREEN}install|i             ${NC}Install a specific laravel version in a given folder
  "
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_laravel_install_explain() {
  echo -e "
  ${GREEN}sajan laravel install
  ${GREEN}s laravel i

  This command will execute the following commands${NC}

  if [[ \$VERSION == '' ]]; then
    echo -e '\${ERRORCOLOR}Please provide a version , choose one from \${NC}'
    git ls-remote --heads https://github.com/laravel/laravel.git | cut -f 2 | cut -b 12-20
    exit
  fi

  if [[ -d '\$FOLDER' ]]; then
    echo -e '\${ERRORCOLLOR}Folder {\$FOLDER} allready exits ... Please remove it first \${NC}'
    exit
  fi

  echo -e '\${INFOCOLOR}Start installation of laravel \${VERSION} into folder \${FOLDER} \${NC}'
  git clone --branch \${VERSION} https://github.com/laravel/laravel.git \${FOLDER}
  cd \$FOLDER
  composer install

  VERSION='\$(php artisan -V)'
  PERSON='\$(whoami)'
  echo -e '\${INFOCOLOR}Congratulations \${PERSON} you sucessfully installed \${VERSION} into folder \${FOLDER} \${NC}'

  ${YELLOW}This command first checks if a version is given , if not a list of all available version is fetched from the internet.
  If a version is provided and the given folder exists then the scripts prompts for deletion of the folder by the user.
  If all parameters are set the specified Laravel version is pulled from the internet.
  The scripts cd's into th folder and installs laravel, fetches the laravel version via artisan and returns a success
  message${NC}

  Used tools for this action:
  - git
  - php
  - composer

  "
  exit
}
################################################################################
# PhpStorm                                                                     #
################################################################################

sajan_phpstorm() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  open|o)
    sajan_phpstorm_open
    exit
    ;;
  *)
    sajan_phpstorm_help
    exit
    ;;
  esac
}

################################################################################
# Test                                                                         #
################################################################################

sajan_phpstorm_test() {
  if ! pstorm --help >/dev/null 2>&1; then
    echo -e "${RED}PhpStorm is not installed on your computer"
    return 0
  else
    echo -e "${INFOCOLOR}PhpStorm is found on your computer"
    return 1
  fi
}

################################################################################
# Help                                                                         #
################################################################################

sajan_phpstorm_help() {
  # Display Help
  echo -e "
${YELLOW}Usage:${NC}"
  echo "  sajan phpstorm [action]"
  echo "  s phpstorm [action]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}open|o             ${NC}Open PhpStorm with current directory"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-e     Explains the command via the dry-run output of the command."
  echo
  echo
}

################################################################################
# Open                                                                         #
################################################################################

sajan_phpstorm_open() {
  OPTION="${OPTIONS['h']}"
  if [ "$OPTION" = "h" ]; then
    echo -e "  ${GREEN}open|o              ${NC}Open PhpStorm with current directory"
    exit
  fi

  if [ "$OPTION" = "e" ]; then
    echo -e "
  ${GREEN}sajan phpstorm open
  ${GREEN}s phpstorm o

  ${GREEN}This command will execute the following commands${NC}

  pstorm .

  ${YELLOW}This will open PhpStorm with the current directory open.${NC}

  Used tools for this action:
  - PhpStorm


  "
    exit
  fi
  pstorm .
}
################################################################################
# Git                                                                          #
################################################################################

sajan_webpack() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  build|b)
    sajan_webpack_build
    exit
    ;;
  init|i)
    sajan_webpack_init
    exit
    ;;
  *)
    sajan_webpack_help
    exit
    ;;
  esac

}

################################################################################
# Test                                                                         #
################################################################################

sajan_webpack_test() {

  if ! node -v >/dev/null 2>&1; then
    echo -e "${RED}Node is not installed on your computer"
    nodeok=0
  else
    echo -e "${INFOCOLOR}Node is found on your computer"
    nodeok=1
  fi

  if ! npm -v >/dev/null 2>&1; then
    echo -e "${RED}Npm is not installed on your computer"
    npmok=0
  else
    echo -e "${INFOCOLOR}Npm is found on your computer"
    npmok=1
  fi

  return ${npmok} && ${nodeok}
}

################################################################################
# Help                                                                         #
################################################################################

sajan_webpack_help() {
  # Display Help
  echo -e "
${YELLOW}Usage:${NC}"
  echo "  sajan webpack [action]"
  echo "  s webpack [action]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}init|i              ${NC}Init webpack for css and javascript in current directory"
  echo -e "  ${GREEN}build|i             ${NC}Build your assets"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-e     Explains the command via the dry-run output of the command."
  echo
  echo
}
################################################################################
# Build                                                                         #
################################################################################

sajan_webpack_build() {

  OPTION="${OPTIONS['h']}"
  if [ "$OPTION" = "h" ]; then
    sajan_webpack_build_help
  fi

  if [ "$OPTION" = "e" ]; then
    sajan_webpack_build_explain
  fi

  npm install
  npm run build
}

################################################################################
# Help                                                                         #
################################################################################

sajan_webpack_build_help() {
  echo -e "
  ${GREEN}build|b             ${NC}Build your assets"
  echo -e "  ${INFOCOLOR}This action will install all npm dependencies and run a build.
  "
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_webpack_build_explain() {
  echo -e "
  ${GREEN}sajan webpack build
  ${GREEN}s webpack b

  This command will execute the following commands${NC}

  npm install
  npm run build

  ${YELLOW}Install npm packages.  Build all assets${NC}

  Used tools for this action:
  - node
  - npm

  "
  exit
}
################################################################################
# Init                                                                         #
################################################################################

sajan_webpack_init() {
  OPTION="${OPTIONS['h']}"
  if [ "$OPTION" = "h" ]; then
    sajan_webpack_init_help
  fi

  if [ "$OPTION" = "e" ]; then
    sajan_webpack_init_explain
  fi

  echo '{
  "private": true,
  "scripts": {
    "build": "webpack --mode development",
    "dist": "webpack --mode production",
    "watch": "webpack --watch --mode development"
  },
  "devDependencies": {
    "compass": "^0.1.1",
    "css-loader": "^5.0.1",
    "mini-css-extract-plugin": "^1.3.1",
    "node-sass": "^5.0.0",
    "sass-loader": "^10.1.0",
    "webpack": "^5.9.0",
    "webpack-cli": "^4.2.0"
  }
}
' >package.json
  mkdir -p sass
  echo "h1 {
  font-size: 25px;
}
" >sass/style.scss
  echo 'const path = require("path");

// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    devtool: false,
    entry: ["./sass/style.scss"],
    output: {
        path: path.resolve(__dirname)
    },
    module: {
        rules: [
            // compile all .scss files to plain old css
            {
                test: /\.(sass|scss)$/,
                use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"]
            }
        ]
    },

    plugins: [
        // extract css into dedicated file
        new MiniCssExtractPlugin({
            filename: "style.css"
        })
    ]
};' >webpack.config.js
  npm install
  npm run build
}

################################################################################
# Help                                                                         #
################################################################################

sajan_webpack_init_help() {
  echo -e "  ${GREEN}init|i              ${NC}Init webpack for css and javascript in current directory"
  echo -e "  ${INFOCOLOR}This action will create all necessary files for javascript and css compilation with webpack
  "
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_webpack_init_explain() {

  echo -e "
  ${GREEN}sajan webpack init
  ${GREEN}s webpack i

  This command will execute the following commands${NC}

  package_config_string > package.json
  mkdir -p sass
  echo 'h1 { font-size: 25px; }' > sass/style.scss
  webpack_config_string > webpack.config.js
  npm install
  npm run build

  ${YELLOW}A configuration json for npm is saved to package.json. This file contains all necessary packages to install.
  A sass directory is created with a style.scss file.
  A webpack configuration file is created , this contains all webpack settings.
  Npm install will install all packages provided in package.json
  A build process is started to create the assets.${NC}

  Used tools for this action:
  - node
  - npm

  "
  exit
}
################################################################################
################################################################################
# Main program                                                                 #
################################################################################

fn_exists() {
  # appended double quote is an ugly trick to make sure we do get a string -- if $1 is not a known command, type does not output anything
  [ $(type -t $1)"" == 'function' ]
}

fn_invalid() {
  Info
  Version
  echo
  Help
  exit
}

################################################################################
# Process the input options. Add options as needed.                            #
################################################################################
# Get the options
declare -a ARGUMENTS=()
declare -a OPTIONS=()

for var in "$@"; do
  if [[ ${var:0:1} == "-" ]]; then
    OPTIONS=("${OPTIONS[@]}" ${var:1})
  else
    ARGUMENTS=("${ARGUMENTS[@]}" $var)
  fi
done

# If no arguments passed then check the base options
if [ "${#ARGUMENTS[@]}" -eq "0" ]; then

  for option in ${OPTIONS[@]}; do

    case $option in
    h) # display Help
      Help
      exit
      ;;
    v) #display version
      Version
      exit
      ;;
    i) #display info
      Info
      exit
      ;;
    \?) # incorrect option
      Help
      exit
      ;;
    esac
  done
fi

# Get the program
PROGRAM=${ARGUMENTS[0]}
# remove program from arguments array
ARGUMENTS=("${ARGUMENTS[@]:1}")

EXEC="sajan_$PROGRAM"
if [[ $PROGRAM == "" ]]; then
  fn_invalid
fi

if ! fn_exists $EXEC; then
  fn_invalid
fi

$EXEC
