
################################################################################
# GO                                                                        #
################################################################################

sajan_git_go() {
  SAJANTIME=$(date +"%m-%d-%Y %H:%M")

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_git_go_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_git_go_explain

  SAJANTIME=$(date +"%m-%d-%Y %H:%M")
  git add .
  git commit -m "sajan push at ${SAJANTIME}"
  git push
}

################################################################################
# Help                                                                        #
################################################################################

sajan_git_go_help() {
  echo -e "
  ${GREEN}go|g                 ${NC}Commit all files and push with a default message"
  echo -e "  ${INFOCOLOR}This action will stash all your files , commit them with a default message and push them to the default remote
  "
  exit
}

################################################################################
# Explain                                                                      #
################################################################################

sajan_git_go_explain() {
  echo -e "
  ${GREEN}sajan git go
  ${GREEN}s git g

  This command will execute the following commands${NC}

  git add .
  git commit -m "sajan push at ${SAJANTIME}"
  git push

  ${YELLOW}The git add stages all changed files. These files are committed with a default sajan commit
  message via the 'commit' command.  After the commit there is a push to your default remote git server.${NC}

  Used tools for this action:
  - git

  "
  exit
}
