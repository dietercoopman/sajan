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

################################################################################
# Clean                                                                        #
################################################################################

sajan_git_clean() {
  OPTION="${OPTIONS['h']}"
  if [ "$OPTION" = "h" ]; then
    echo -e "  ${GREEN}clean              ${NC}Reset and clean current git directory"
    exit
  fi

  if [ "$OPTION" = "e" ]; then
    echo -e "
  ${GREEN}sajan git clean

  This command will execute the following commands${NC}

  git reset --hard
  git add .
  git pull"
    echo -e "
  ${YELLOW}The active branch is reset to the git index, so all changes are reset. Git add .
  will stage all files (that are not listed in the .gitignore) in the entire repository.
  Remote changes are pulled into your branch.${NC}

  "

    exit
  fi

  git reset --hard
  git add .
  git pull
}

################################################################################
# Clean                                                                        #
################################################################################

sajan_git_go() {
  SAJANTIME=$(date +"%m-%d-%Y %H:%M")
  OPTION="${OPTIONS['h']}"

  if [ "$OPTION" = "h" ]; then
    echo -e "  ${GREEN}go                 ${NC}Commit all files and push with a default message"
    echo -e "  ${INFOCOLOR}This action will stash all your files , commit them with a default message and push them to the default remote"
    exit
  fi

  if [ "$OPTION" = "e" ]; then
    echo -e "
  ${GREEN}git go

  This command will execute the following commands${NC}

  git add .
  git commit -m "sajan push at ${SAJANTIME}"
  git push

  ${YELLOW}The git add stages all changed files. These files are committed with a default sajan commit
  message via the 'commit' command.  After the commit there is a push to your default remote git server.${NC}

  "

    exit
  fi

  SAJANTIME=$(date +"%m-%d-%Y %H:%M")
  git add .
  git commit -m "sajan push at ${SAJANTIME}"
  git push
}
