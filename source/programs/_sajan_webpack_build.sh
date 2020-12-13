################################################################################
# Build                                                                         #
################################################################################

sajan_webpack_build() {

  OPTION="${OPTIONS['h']}"
  if [ "$OPTION" = "h" ]; then
    sajan_webpack_build_help
  fi

  if [ "$OPTION" = "e" ]; then
    sajan_webpack_build_explain
  fi

  npm install
  npm run build
}

################################################################################
# Help                                                                         #
################################################################################

sajan_webpack_build_help() {
  echo -e "
  ${GREEN}build|b             ${NC}Build your assets"
  echo -e "  ${INFOCOLOR}This action will install all npm dependencies and run a build.
  "
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_webpack_build_explain() {
  echo -e "
  ${GREEN}sajan webpack build
  ${GREEN}s webpack b

  This command will execute the following commands${NC}

  npm install
  npm run build

  ${YELLOW}Install npm packages.  Build all assets${NC}
  "
  exit
}
