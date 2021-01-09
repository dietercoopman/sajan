
################################################################################
# Alias                                                                        #
################################################################################

sajan_aliases() {
  echo "list aliases"
  fn_array_contains "h" "${OPTIONS[@]}" && sajan_aliases_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_aliases_explain

  INPUT="$(cat  ~/.bash_profile | grep alias)"
  INPUT=${INPUT//alias /----}
  INPUT=${INPUT//\=\"/|\\t\\t\\t}
  INPUT=${INPUT//\"/}
  INPUT=${INPUT//----/\\n}

  echo -e Alias\|\\t\\t\\tProgram$INPUT > /tmp/sajan_aliases.txt
  column -t -s '|' /tmp/sajan_aliases.txt
  #rm /tmp/sajan_aliases.txt
}

################################################################################
# Help                                                                        #
################################################################################

sajan_aliases_help() {
  echo -e "
  ${GREEN}aliases             ${NC}Show all aliases on your system"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_aliases_explain() {
  echo -e "
  ${GREEN}sajan aliases

  This command will execute the following actions${NC}

  It will read the ~/.bash_profile, parse the input and write the parsed content to a tmp file.
  Column command will read the file and show all alias variables in a table

  Used tools for this action:
  - bash

  "
  exit
}
