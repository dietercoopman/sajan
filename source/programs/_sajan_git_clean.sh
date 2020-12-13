################################################################################
# Clean                                                                        #
################################################################################

sajan_git_clean() {
  OPTION="${OPTIONS['h']}"

  if [ "$OPTION" = "h" ]; then
    sajan_git_clean_help
  fi

  if [ "$OPTION" = "e" ]; then
    sajan_git_clean_explain
  fi

  git reset --hard
  git add .
  git pull
}

################################################################################
# Help                                                                        #
################################################################################

sajan_git_clean_help() {
  echo -e "
  ${GREEN}clean|c              ${NC}Reset and clean current git directory
  "
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_git_clean_explain() {
  echo -e "
  ${GREEN}sajan git clean
  ${GREEN}s git c

  This command will execute the following commands${NC}

  git reset --hard
  git add .
  git pull"
  echo -e "
  ${YELLOW}The active branch is reset to the git index, so all changes are reset. Git add .
  will stage all files (that are not listed in the .gitignore) in the entire repository.
  Remote changes are pulled into your branch.${NC}

  Used tools for this action:
  - git

  "
  exit
}
