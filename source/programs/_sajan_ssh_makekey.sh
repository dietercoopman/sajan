################################################################################
# Make key                                                                        #
################################################################################

sajan_ssh_makekey() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_ssh_makekey_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_ssh_makekey_explain

  ssh-keygen -t rsa

}

################################################################################
# Help                                                                        #
################################################################################

sajan_ssh_makekey_help() {
  echo -e "
  ${GREEN}makekey|m              ${NC}Create an ssh key on your computer"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_ssh_makekey_explain() {
  echo -e "
  ${GREEN}sajan ssh makekey
  ${GREEN}s ssh m

  This command will execute the following commands${NC}

  ssh-keygen -t rsa

  ${YELLOW}This command will generate an ssh key pair on your computer${NC}

  Used tools for this action:
  - ssh-keygen

  "
  exit
}
