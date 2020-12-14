
################################################################################
# Update                                                                       #
################################################################################

sajan_tools_update() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_tools_update_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_tools_update_explain

  echo -e "${INFOCOLOR}Start updating toolset , brew , npm , git , node "
  brew upgrade
  echo -e "${GREEN}All tools are updated , enjoy using sajan !"

}

################################################################################
# Help                                                                         #
################################################################################

sajan_tools_update_help() {
  echo -e "
  ${GREEN}update        ${NC}Update tools used by sajan"
  echo -e "  ${INFOCOLOR}This actions will upgrade all installed brew formulae."
echo
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_tools_update_explain() {
  echo -e "
  ${GREEN}sajan tools update
  ${GREEN}s tools u

  This command will execute the following commands${NC}

     brew upgrade

  ${YELLOW}This program will upgrade all installed brew packages.${NC}

  Used tools for this action:
  - brew

  "
  exit
}
