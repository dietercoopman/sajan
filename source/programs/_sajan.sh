declare BRANDCOLOR='\033[0;33m'
declare INFOCOLOR='\033[0;36m'
declare ERRORCOLOR='\033[1;101m'

declare GREEN='\033[0;32m'
declare YELLOW='\033[0;33m'
declare NC='\033[0m'
declare VERSION=0.2

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
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}self-update         ${NC}Update sajan"
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
${GREEN}Sajan${NC} is a light tool to automize some web development tasks
This tool provides you with some automation tasks for Laravel, Git, PhpStorm and Webpack
"

}

sajan_self-update(){
  curl -s https://raw.githubusercontent.com/dietercoopman/sajan/master/bin/sajan -o sajan
  mv sajan /usr/local/bin
  chmod +x /usr/local/bin/sajan
  echo "Sajan has been updated to version $VERSION"
  exit
}