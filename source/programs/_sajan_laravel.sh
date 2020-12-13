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