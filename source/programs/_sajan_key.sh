################################################################################
# Ssh                                                                          #
################################################################################

sajan_key() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  copy | c)
    sajan_key_copy
    exit
    ;;
  dir | d)
    sajan_key_dir
    exit
    ;;
  make | m)
    sajan_key_make
    exit
    ;;
  push | p)
  sajan_key_push
  exit
  ;;

  *)
    sajan_key_help
    exit
    ;;
  esac

}


################################################################################
# Help                                                                         #
################################################################################

sajan_key_help() {
  # Display Help
  echo -e "
${YELLOW}Usage:${NC}"
  echo "  sajan key [action]"
  echo "  s key [action]"

  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}copy|c             ${NC}Copy the public key of a key pair to your clipboard"
  echo -e "  ${GREEN}dir|d              ${NC}Cd into your ssh keys folder"
  echo -e "  ${GREEN}make|m             ${NC}Create an ssh key"
  echo -e "  ${GREEN}push|p             ${NC}Push a provided ssh key to a ssh server"  
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-e     Explains the command via the dry-run output of the command.${NC}"
  echo
  echo
}
