
################################################################################
# Laravel                                                                      #
################################################################################

sajan_laravel() {
  ACTION="$1"

  case $ACTION in
  install)
    sajan_laravel_install $2 $3
    exit
    ;;
 update)
    sajan_laravel_update
    exit
    ;;
  "-h"|*|"")
    sajan_laravel_help
    exit
    ;;
  esac
}

################################################################################
# Help                                                                         #
################################################################################

sajan_laravel_help() {
  # Display Help
  echo -e "${YELLOW}Usage:${NC}"
  echo " sajan laravel [action]";
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}install             ${NC}Install a specific laravel version in a given folder"
  echo -e "  ${GREEN}update              ${NC}Update your project and all its composer dependencies"
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

  echo $1
}

################################################################################
# Update                                                                       #
################################################################################

sajan_laravel_update() {
  echo "update your laravel"
}