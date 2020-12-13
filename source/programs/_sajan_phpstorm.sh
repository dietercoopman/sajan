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
