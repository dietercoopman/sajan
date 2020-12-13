declare BRANDCOLOR='\033[0;33m'
declare INFOCOLOR='\033[0;36m'
declare ERRORCOLOR='\033[1;101m'

declare GREEN='\033[0;32m'
declare YELLOW='\033[0;33m'
declare NC='\033[0m'
declare VERSION=0.9-alfa

################################################################################
# VERSION                                                                      #
################################################################################

Version() {
  echo -e "${GREEN}Sajan${NC} version ${YELLOW}$VERSION${NC} by Dieter Coopman"
}

################################################################################
# Help                                                                         #
################################################################################

Help() {
  # Display Help
  echo -e "${YELLOW}Usage:${NC}"
  echo " sajan [program] [action] [--]"
  echo " s [program] [action] [--]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}self-update         ${NC}Update sajan"
  echo -e "  ${GREEN}tools-check         ${NC}Check if all tools needed for sajan are present"
  echo -e "  ${GREEN}tools-update        ${NC}Update tools used by sajan"
  echo -e "  ${GREEN}tools-install       ${NC}Install the tools used by sajan"

  echo
  echo -e "${YELLOW}Programs:"
  echo -e "  ${GREEN}laravel             ${NC}Execute Laravel actions"
  echo -e "  ${GREEN}git                 ${NC}Execute Git actions"
  echo -e "  ${GREEN}phpstorm            ${NC}Execute PhpStorm actions"
  echo -e "  ${GREEN}webpack             ${NC}Execute Webpack actions"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-v     Print software version and exit."
  echo -e "  ${GREEN}-i     Print software information and exit."
  echo
  echo
}

################################################################################
# Info                                                                         #
################################################################################

Info() {
  echo -e "${BRANDCOLOR}
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
                         JJJJJJJ JJJJJJJ
           JJJJJJJ       JJJJJJJ JJJJJJJ       JJJJJJJ
           JJJJJJJ       JJJJJJJ JJJJJJJ       JJJJJJJ
           JJJJJJJ       JJJJJJJ JJJJJJJ       JJJJJJJ
            JJJJJJJ      JJJJJJJ JJJJJJJJ     JJJJJJJJ
            JJJJJJJJJJJJJJJJJJJ   JJJJJJJJJJJJJJJJJJJ
              JJJJJJJJJJJJJJJ       JJJJJJJJJJJJJJJ
            JJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJ
            JJJJJJJJJJASPERJJJJJJJJJJJJANAJJJJJJJJJJJ
            JJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJJ
${NC}
${GREEN}Sajan${NC} is a lightweight tool to automize some web development tasks
This tool provides you with some automation tasks for Laravel, Git, PhpStorm and Webpack
"

}

sajan_self-update() {
  curl -s https://raw.githubusercontent.com/dietercoopman/sajan/master/bin/sajan -o sajan
  mv sajan /usr/local/bin
  chmod +x /usr/local/bin/sajan
  ln -s /usr/local/bin/sajan /usr/local/bin/s
  echo -e "${GREEN}Sajan${NC} has been updated to version ${YELLOW}$VERSION${NC}"
  exit
}

sajan_brew_test() {
  if ! brew --version >/dev/null 2>&1; then
    echo -e "${RED}Brew is not installed on your computer"
    return 0
  else
    echo -e "${INFOCOLOR}Brew is found on your computer"
    return 1
  fi
}

sajan_tools-check() {
  sajan_brew_test
  BREWOK=$?
  sajan_git_test
  GITOK=$?
  sajan_laravel_test
  LARAVELOK=$?
  sajan_phpstorm_test
  PHPSTORMOK=$?
  sajan_webpack_test
  WEBPACKOK=$?

  ALLOK=$(($BREWOK + $GITOK + $LARAVELOK + $PHPSTORMOK + $WEBPACKOK))

  if [[ $ALLOK == 5 ]]; then
    echo -e "${GREEN}All tools are set , enjoy sajan !"
  else
    echo -e "${ERRORCOLOR}Not all tools are set , review the red lines "
  fi
}

sajan_tools-update() {
  echo -e "${INFOCOLOR}Start updating toolset , brew , npm , git , node "
  brew upgrade
  npm update -g
  echo -e "${GREEN}All tools are updated , enjoy using sajan !"
}

sajan_tools-install() {
  echo -e "${INFOCOLOR}Installing sayan toolset , brew , node , npm , git , composer "
  /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
  brew install npm
  brew install node
  brew install git
  brew install composer
  echo -e "${GREEN}All tools are installed , enjoy using sajan !"
}
