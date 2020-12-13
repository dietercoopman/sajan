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
  echo
  echo
}

################################################################################
# Clean                                                                        #
################################################################################

sajan_git_clean() {
  git reset --hard
  git add .
  git pull
}

################################################################################
# Clean                                                                        #
################################################################################

sajan_git_go() {

  SAJANTIME=$(date +"%m-%d-%Y %H:%M")
  git add .
  git commit -m "sajan push at ${SAJANTIME}"
  git push
}
