################################################################################
# Alias                                                                        #
################################################################################

sajan_alias() {
  fn_array_contains "h" "${OPTIONS[@]}" && sajan_alias_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_alias_explain

  echo
  echo -e "  Which program/command do you want to alias ? ${NC}\c"
  read PROGRAM

  echo -e "  Which name do you choose for your alias ? ${NC}\c"
  read NAME
  echo

  echo "alias $NAME=\"${PROGRAM}\"" >>~/.bash_profile

  echo -e "  Your alias ${YELLOW}$NAME${NC} is ready for use , did you know you can list all your aliases by typing '${YELLOW}alias${NC}'"
  echo

  if [ "$SHELL" == "/bin/zsh" ]; then
    echo source ~/.bash_profile >~/.zshenv
    source ~/.zshenv
    exec zsh -l
  else
    source ~/.bash_profile
    exec bash -l
  fi

}

################################################################################
# Help                                                                        #
################################################################################

sajan_alias_help() {
  echo -e "
  ${GREEN}alias              ${NC}Create an alias for a program or command"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_alias_explain() {
  echo -e "
  ${GREEN}sajan alias

  This command will execute the following commands${NC}

  echo alias name=\"program\" >>  ~/.bash_profile
  source ~/.bash_profile"

  echo -e "
  ${YELLOW}This command will create a provided alias for a given program.
  If you want to delete an alias, remove it from you ~/.bash_profile file.  A sajan command will be provided soon.${NC}

  Used tools for this action:
  - bash

  "
  exit
}
