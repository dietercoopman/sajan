################################################################################
# Make key                                                                        #
################################################################################

sajan_ssh_dir() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_ssh_dir_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_ssh_dir_explain

  cd ~/.ssh
  $SHELL

}

################################################################################
# Help                                                                        #
################################################################################

sajan_ssh_dir_help() {
  echo -e "
  ${GREEN}dir|d             ${NC}Cd into your ssh folder"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_ssh_dir_explain() {
  echo -e "
  ${GREEN}sajan ssh dir
  ${GREEN}s ssh d

  This command will execute the following commands${NC}

  cd ~/.ssh
  \$SHELL

  ${YELLOW}This command will cd into your ssh folder${NC}

  "
  exit
}
