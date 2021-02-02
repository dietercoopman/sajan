################################################################################
# Make key                                                                        #
################################################################################

sajan_key_make() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_key_make_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_key_make_explain

  ssh-keygen -t rsa

}

################################################################################
# Help                                                                        #
################################################################################

sajan_key_make_help() {
  echo -e "
  ${GREEN}make|m              ${NC}Create an ssh key on your computer"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_key_make_explain() {
  echo -e "
  ${GREEN}sajan key make
  ${GREEN}s key m

  This command will execute the following commands${NC}

  ssh-keygen -t rsa

  ${YELLOW}This command will generate an ssh key pair on your computer${NC}

  Used tools for this action:
  - ssh-keygen

  "
  exit
}
