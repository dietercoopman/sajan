################################################################################
# Git                                                                          #
################################################################################

sajan_git() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  clean)
    sajan_git_clean
    exit
    ;;
  go)
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
  echo -e "${YELLOW}Usage:${NC}"
  echo " sajan git [action]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}clean              ${NC}Reset and clean current git directory"
  echo -e "  ${GREEN}go                 ${NC}Commit all files and push with a default message"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-e     Explains the command via the dry-run output of the command."
  echo
  echo
}