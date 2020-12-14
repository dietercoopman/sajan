
################################################################################
# Clean                                                                        #
################################################################################

sajan_git_clean() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_git_clean_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_git_clean_explain

  echo -e "Are your sure you want to clean up ? This will remove uncommitted changes (y/n)? ${NC}\c"
  read sure
  if [ "$sure" == "y" ]; then
    echo "test"
    exit
    git reset --hard
    git add .
    git pull
  fi

}

################################################################################
# Help                                                                        #
################################################################################

sajan_git_clean_help() {
  echo -e "
  ${GREEN}clean|c              ${NC}Reset and clean current git directory"
  echo
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
