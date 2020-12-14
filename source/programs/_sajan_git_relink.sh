
################################################################################
# RELINK                                                                       #
################################################################################

sajan_git_relink() {
  SAJANTIME=$(date +"%m-%d-%Y %H:%M")

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_git_relink_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_git_relink_explain

  echo
  CURRENTREMOTE=$(git remote)
  CURRENTREMOTEURL=$(git config --get remote.origin.url)
  echo -e "This is your current remote name :     ${YELLOW}$CURRENTREMOTE${NC}"
  echo -e "This is your remote url :              ${YELLOW}$CURRENTREMOTEURL${NC}"
  echo
  read -p "What is the name of your new remote ? [$CURRENTREMOTE]: " NEWREMOTE
  NEWREMOTE=${NEWREMOTE:-$CURRENTREMOTE}
  read -p "What is your new remote url ? [$CURRENTREMOTEURL]: " NEWURL
  NEWURL=${NEWURL:-$CURRENTREMOTEURL}

  git remote set-url $NEWREMOTE $NEWURL

  echo
  CURRENTREMOTE=$(git remote)
  CURRENTREMOTEURL=$(git config --get remote.origin.url)
  echo -e "This is your new remote name :        ${YELLOW}$CURRENTREMOTE${NC}"
  echo -e "This is new remote url :              ${YELLOW}$CURRENTREMOTEURL${NC}"
  echo
  echo "Happy git-ing !! "
  echo

}

################################################################################
# Help                                                                        #
################################################################################

sajan_git_relink_help() {
  echo -e "
  ${GREEN}relink|rln                 ${NC}Change your remote"
  echo -e "  ${INFOCOLOR}Relink your current git to a new remote git url.
  "
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_git_relink_explain() {
  echo -e "
  ${GREEN}sajan git relink
  ${GREEN}s git rln

  This command will execute the following commands${NC}

  git remote set-url newremote newurl

  ${YELLOW}This command will show your current origin name and url and prompt for a new remote and url${NC}

  Used tools for this action:
  - git

  "
  exit
}
