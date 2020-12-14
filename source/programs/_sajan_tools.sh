################################################################################
# Tools                                                                        #
################################################################################

sajan_tools() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  check | c)
    sajan_tools_check
    ;;
  update | u)
    sajan_tools_update
    exit
    ;;
  install | i)
    sajan_tools_install
    exit
    ;;
  *)
    sajan_tools_help
    exit
    ;;
  esac

}

################################################################################
# Test                                                                         #
################################################################################
sajan_brew_test() {
  if ! brew --version >/dev/null 2>&1; then
    echo -e "${RED}Brew is not installed on your computer"
    return 0
  else
    echo -e "${INFOCOLOR}Brew is found on your computer"
    return 1
  fi
}

################################################################################
# Help                                                                         #
################################################################################

sajan_tools_help() {
  # Display Help
  echo -e "
${YELLOW}Usage:${NC}"
  echo "  sajan tools [action]"

  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}install       ${NC}Install the tools used by sajan"
  echo -e "  ${GREEN}update        ${NC}Update tools used by sajan"
  echo -e "  ${GREEN}check         ${NC}Check if all tools needed for sajan are present"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-e     Explains the command via the dry-run output of the command."
  echo
  echo
}
