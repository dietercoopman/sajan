################################################################################
# Make key                                                                        #
################################################################################

sajan_key_dir() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_key_dir_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_key_dir_explain

  cd ~/.ssh
  $SHELL

}

################################################################################
# Help                                                                        #
################################################################################

sajan_key_dir_help() {
  echo -e "
  ${GREEN}dir|d             ${NC}Cd into your ssh folder"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_key_dir_explain() {
  echo -e "
  ${GREEN}sajan key dir
  ${GREEN}s key d

  This command will execute the following commands${NC}

  cd ~/.ssh
  \$SHELL

  ${YELLOW}This command will cd into your ssh folder${NC}

  "
  exit
}
