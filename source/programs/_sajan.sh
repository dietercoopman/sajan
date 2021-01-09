declare BRANDCOLOR='\033[0;33m'
declare INFOCOLOR='\033[0;36m'
declare ERRORCOLOR='\033[1;101m'
declare LOVECOLOR='\033[31m'

declare GREEN='\033[0;32m'
declare YELLOW='\033[0;33m'
declare NC='\033[0m'
declare VERSION=v0.30-beta

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
  echo -e "
${YELLOW}Usage:${NC}"
  echo "  sajan [program] [action] [--]"
  echo "  s     [program] [action] [--]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}self-update         ${NC}Update sajan"
  echo -e "  ${GREEN}bye                 ${NC}Delete sajan"
  echo -e "  ${GREEN}alias               ${NC}Create an alias for a program or command"
  echo -e "  ${GREEN}aliases             ${NC}Show all user defined aliases on your system"

  echo
  echo -e "${YELLOW}Programs:"
  echo -e "  ${GREEN}tools               ${NC}Execute Tools actions"
  echo -e "  ${GREEN}apache              ${NC}Execute Apache actions"
  echo -e "  ${GREEN}laravel             ${NC}Execute Laravel actions"
  echo -e "  ${GREEN}git                 ${NC}Execute Git actions"
  echo -e "  ${GREEN}phpstorm            ${NC}Execute PhpStorm actions"
  echo -e "  ${GREEN}webpack             ${NC}Execute Webpack actions"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-v     Print software version and exit."
  echo -e "  ${GREEN}-i     Print software information and exit.${NC}"
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
This tool provides you with some automation tasks for Laravel, Git, PhpStorm and Webpack${NC}
"

}

sajan_self-update() {
  curl -H 'Cache-Control: no-cache' -s https://raw.githubusercontent.com/dietercoopman/sajan/master/bin/sajan -o sajan
  mv -f sajan /usr/local/bin
  chmod +x /usr/local/bin/sajan
  ln -sfn /usr/local/bin/sajan /usr/local/bin/s
  echo -e "${GREEN}Sajan${NC} has been updated to version ${YELLOW}$VERSION${NC}"
  exit
}

sajan_bye() {
  # clear sessions
  echo -e "
  ${INFOCOLOR}I hope you mistyped ;-) ...
  Are you sure you want to delete sajan (y/n)? ${NC}\c"
  read sure
  case "$sure" in
  'y')

    echo "
  I'm sorry to see you leaving ... Bye Bye !! I am allready self-destroying ..."
    rm /usr/local/bin/s
    rm /usr/local/bin/sajan
    echo "
  And now I'm gone ... :( I'll prove with an error :(
   "
    sajan -v
    ;;
  *)
    echo -e "${NC}
  I love you tooooo ${LOVECOLOR}♥♥♥♥${NC} ... I'll do a self test ... Am i still here ???
  "
    sajan -v
    echo "
  Pfieeuw ... "

    ;;
  esac
  echo -e ''
}
