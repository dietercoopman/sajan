
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
