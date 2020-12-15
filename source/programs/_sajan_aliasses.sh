################################################################################
# Alias                                                                        #
################################################################################

sajan_aliasses() {
  fn_array_contains "h" "${OPTIONS[@]}" && sajan_aliasses_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_aliasses_explain

  aliasses

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

  This command will execute the following commands${NC}

  alias

  Used tools for this action:
  - bash

  "
  exit
}
