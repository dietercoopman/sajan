
################################################################################
# Apache                                                                       #
################################################################################

sajan_apache() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  list | l)
    sajan_apache_list
    exit
    ;;
  *)
    sajan_apache_help
    exit
    ;;
  esac

}

################################################################################
# Test                                                                         #
################################################################################

sajan_apache_test() {
  if ! apachectl -v >/dev/null 2>&1; then
    echo -e "${RED}Apache is not installed on your system"
    return 0
  else
    echo -e "${INFOCOLOR}Apache is found on your system"
    return 1
  fi
}

################################################################################
# Help                                                                         #
################################################################################

sajan_apache_help() {
  # Display Help
  echo -e "
${YELLOW}Usage:${NC}"
  echo "  sajan apache [action]"

  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}list|             ${NC}List all active sites on your system"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-e     Explains the command via the dry-run output of the command.${NC}"
  echo
  echo
}
