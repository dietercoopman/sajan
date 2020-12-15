
################################################################################
# Alias                                                                        #
################################################################################

sajan_alias() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_alias_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_alias_explain

  echo -e "Which program/command do you want to alias ? ${NC}\c"
  read PROGRAM

  echo -e "Which name do you choose for your alias ? ${NC}\c"
  read NAME

  echo "alias $NAME=\"${PROGRAM}\"" >>  ~/.bash_profile
  source ~/.bash_profile
  echo "If your alias does not work immediatly please run 'source ~/.bash_profile'"

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
  ${YELLOW}This command will create a provided alias for a given program ${NC}

  Used tools for this action:
  - bash

  "
  exit
}
