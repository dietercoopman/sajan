
################################################################################
# PhpStorm                                                                     #
################################################################################

sajan_phpstorm() {
  ACTION=$1

  case $ACTION in
  open)
    sajan_phpstorm_open
    exit
    ;;
  "-h" | * | "")
    sajan_phpstorm_help
    exit
    ;;
  esac
}

################################################################################
# Help                                                                         #
################################################################################

sajan_phpstorm_help() {
  # Display Help
  echo -e "${YELLOW}Usage:${NC}"
  echo " sajan phpstorm [action]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}open              ${NC}Open PhpStorm with current directory"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo
  echo
}

################################################################################
# Open                                                                         #
################################################################################

sajan_phpstorm_open() {
  pstorm .
}
