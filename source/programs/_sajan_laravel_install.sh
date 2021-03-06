
################################################################################
# Install                                                                      #
################################################################################

sajan_laravel_install() {
  local VERSION=${ARGUMENTS[1]}
  local FOLDER=${ARGUMENTS[2]}

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_laravel_install_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_laravel_install_explain

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
  ${GREEN}install|i  [version] [folder]     ${NC}Install a specific laravel version in a given folder
  "
  echo
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_laravel_install_explain() {
  echo -e "
  ${GREEN}sajan laravel install [version] [folder]
  ${GREEN}s laravel i [version] [folder]

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
