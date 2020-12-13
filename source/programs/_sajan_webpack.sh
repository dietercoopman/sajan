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

