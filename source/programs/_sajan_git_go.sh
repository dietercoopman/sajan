################################################################################
# GO                                                                        #
################################################################################

sajan_git_go() {
  SAJANTIME=$(date +"%m-%d-%Y %H:%M")
  OPTION="${OPTIONS['h']}"

  if [ "$OPTION" = "h" ]; then
    sajan_git_go_help
  fi

  if [ "$OPTION" = "e" ]; then
    sajan_git_go_explain
  fi

  SAJANTIME=$(date +"%m-%d-%Y %H:%M")
  git add .
  git commit -m "sajan push at ${SAJANTIME}"
  git push
}

sajan_git_go_explain() {
  echo -e "  ${GREEN}go                 ${NC}Commit all files and push with a default message"
  echo -e "  ${INFOCOLOR}This action will stash all your files , commit them with a default message and push them to the default remote"
  exit

}

sajan_git_go_explain() {
  echo -e "
  ${GREEN}git go

  This command will execute the following commands${NC}

  git add .
  git commit -m "sajan push at ${SAJANTIME}"
  git push

  ${YELLOW}The git add stages all changed files. These files are committed with a default sajan commit
  message via the 'commit' command.  After the commit there is a push to your default remote git server.${NC}

  "
  exit
}
