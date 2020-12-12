################################################################################
# Git                                                                          #
################################################################################

sajan_git() {
  ACTION="$1"

  case $ACTION in
  clean)
    sajan_git_clean $2 $3
    exit
    ;;
  "-h" | * | "")
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
    echo -e "${RED}Git not installed"
    return 0
  else
    echo -e "${INFOCOLOR}Git installed"
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
