
################################################################################
# Alias                                                                        #
################################################################################

sajan_aliasses() {
  echo "list aliasses"
  fn_array_contains "h" "${OPTIONS[@]}" && sajan_aliasses_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_aliasses_explain

  INPUT="$(cat  ~/.bash_profile | grep alias)"
  INPUT=${INPUT//alias /----}
  INPUT=${INPUT//=/}
  INPUT=${INPUT//\"/\\t\\t\\t\\t\\t}
  INPUT=${INPUT//----/\\n}
  echo -e ${YELLOW}Alias\\t\\t\\t\\t\\tProgram${NC} $INPUT > /tmp/sajan_aliasses.txt
  column -t -s $'\n' /tmp/sajan_aliasses.txt
  rm /tmp/sajan_aliasses.txt
}

################################################################################
# Help                                                                        #
################################################################################

sajan_aliasses_help() {
  echo -e "
  ${GREEN}aliasses             ${NC}Show all aliasses on your system"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_aliasses_explain() {
  echo -e "
  ${GREEN}sajan aliasses

  This command will execute the following actions${NC}

  It will read the ~/.bash_profile, parse the input and write the parsed content to a tmp file.
  Column command will read the file and show all alias variables in a table

  Used tools for this action:
  - bash

  "
  exit
}
