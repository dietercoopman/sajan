################################################################################
# Ssh                                                                          #
################################################################################

sajan_ssh() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  copykey | c)
    sajan_ssh_copykey
    exit
    ;;
  dir | d)
    sajan_ssh_dir
    exit
    ;;
  makekey | m)
    sajan_ssh_makekey
    exit
    ;;

  *)
    sajan_ssh_help
    exit
    ;;
  esac

}


################################################################################
# Help                                                                         #
################################################################################

sajan_ssh_help() {
  # Display Help
  echo -e "
${YELLOW}Usage:${NC}"
  echo "  sajan ssh [action]"
  echo "  s ssh [action]"

  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}copykey|c             ${NC}Read the public key of a key pair"
  echo -e "  ${GREEN}dir|d                 ${NC}Cd into your ssh folder"
  echo -e "  ${GREEN}makekey|m             ${NC}Create an ssh key"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-e     Explains the command via the dry-run output of the command.${NC}"
  echo
  echo
}
