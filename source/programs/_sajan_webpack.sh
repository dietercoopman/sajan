
################################################################################
# Git                                                                          #
################################################################################

sajan_webpack() {
  ACTION="$1"

  case $ACTION in
  build)
    sajan_webpack_build $2
    exit
    ;;
  init)
    sajan_webpack_init
    exit
    ;;
   "-h"|*|"")
    sajan_webpack_help
    exit
    ;;
  esac

}

################################################################################
# Help                                                                         #
################################################################################

sajan_webpack_help() {
  # Display Help
  echo -e "${YELLOW}Usage:${NC}"
  echo " sajan webpack [action]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}init              ${NC}Init webpack for current directory"
  echo -e "  ${GREEN}build             ${NC}Build your assets"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo
  echo
}


################################################################################
# Init                                                                         #
################################################################################

sajan_webpack_init() {
  echo "Init not implemented yet"
}

################################################################################
# Build                                                                         #
################################################################################

sajan_webpack_build(){
  echo "Build not implemented yet"
}