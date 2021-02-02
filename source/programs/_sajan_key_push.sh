################################################################################
# Make key                                                                        #
################################################################################

sajan_key_push() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_key_push_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_key_push_explain

  cd ~/.ssh

  ARRAY=($(ls | grep pub))
  COUNT="0"
  DUMMYPUBKEY=1

  for i in ${ARRAY[*]}; do
    echo "[$(($COUNT + 1))]  $i"
    let COUNT++
  done

  read -p "Which key do you want to copy ? [$DUMMYPUBKEY]: " PUBKEY
  PUBKEY=${PUBKEY:-$DUMMYPUBKEY}
  FILE=${ARRAY[$PUBKEY - 1]}

  read -p "Provide the username and hostname of the server you want to push the key to ( ex.  user@hostname ) ?: " SERVER
 
  ssh-copy-id -i ~/.ssh/$FILE $SERVER

  echo -e "${GREEN}the key $FILE has been pushed to the server $SERVER${NC}"

}

################################################################################
# Help                                                                        #
################################################################################

sajan_key_push_help() {
  echo -e "
  ${GREEN}push|p              ${NC}Push a provided ssh key to an ssh server"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_key_push_explain() {
  echo -e "
  ${GREEN}sajan key push
  ${GREEN}s key p

  This command will execute the following commands${NC}

  ssh-copy-id -i ~/.ssh/$FILE $SERVER

  ${YELLOW}This command will push a provided ssh key to a given server${NC}

  Used tools for this action:
  - ssh-copy-id

  "
  exit
}
