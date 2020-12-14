################################################################################
# Install                                                                      #
################################################################################

sajan_tools_install() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_tools_install_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_tools_install_explain

  read -p "Are your sure you want to install brew (y/n) ? [y]: " sure
  if [ "$sure" == "y" ]; then
    echo -e "${INFOCOLOR}Installing sayan toolset , brew , node , npm , git , composer "
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
    brew install npm
    brew install node
    brew install git
    brew install composer
    echo -e "${GREEN}All tools are installed , enjoy using sajan !"
  fi
}

################################################################################
# Help                                                                         #
################################################################################

sajan_tools_install_help() {
  echo -e "
  ${GREEN}install       ${NC}Install the tools used by sajan"
  echo -e "  ${INFOCOLOR}This actions will install brew first.  Then npm, node, git and composer via brew."
echo
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_tools_install_explain() {
  echo -e "
  ${GREEN}sajan tools install
  ${GREEN}s tools i

  This command will execute the following commands${NC}

    /bin/bash -c '\$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)'
    brew install npm
    brew install node
    brew install git
    brew install composer


 ${YELLOW}This program first ask the user confirmation to install brew itself.  After this installation
 npm, node, git and composer are installed via brew.${NC}

  Used tools for this action:
  - brew

  "
  exit
}
