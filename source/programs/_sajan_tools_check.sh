
################################################################################
# Check                                                                        #
################################################################################

sajan_tools_check() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_tools_check_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_tools_check_explain

  sajan_brew_test
  BREWOK=$?
  sajan_git_test
  GITOK=$?
  sajan_laravel_test
  LARAVELOK=$?
  sajan_phpstorm_test
  PHPSTORMOK=$?
  sajan_webpack_test
  WEBPACKOK=$?

  ALLOK=$(($BREWOK + $GITOK + $LARAVELOK + $PHPSTORMOK + $WEBPACKOK))

  if [[ $ALLOK == 5 ]]; then
    echo -e "${GREEN}All tools are set , enjoy sajan !"
  else
    echo -e "${ERRORCOLOR}Not all tools are set , review the red lines "
  fi
}

################################################################################
# Help                                                                         #
################################################################################

sajan_tools_check_help() {
  echo -e "
  ${GREEN}check         ${NC}Check if all tools needed for sajan are present"
  echo -e "  ${INFOCOLOR}This action will test if brew, git, composer, phpstorm and webpack is installed."
  echo
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_tools_check_explain() {
  echo -e "
  ${GREEN}sajan tools check
  ${GREEN}s tools c

  This command will execute the following commands${NC}

  brew --version
  git --version
  comopser -V
  node -v
  npm -v

 ${YELLOW}This command checks the version of all the uses programs to see if they are installed${NC}

  Used tools for this action:
  - brew
  - git
  - composer
  - node
  - npm

  "
  exit
}
