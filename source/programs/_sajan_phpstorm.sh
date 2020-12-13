################################################################################
# PhpStorm                                                                     #
################################################################################

sajan_phpstorm() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  open)
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
  echo -e "${YELLOW}Usage:${NC}"
  echo " sajan phpstorm [action]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}open              ${NC}Open PhpStorm with current directory"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo
  echo
}

################################################################################
# Open                                                                         #
################################################################################

sajan_phpstorm_open() {
  pstorm .
}
