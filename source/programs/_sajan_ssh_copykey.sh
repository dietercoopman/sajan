################################################################################
# Make key                                                                        #
################################################################################

sajan_ssh_copykey() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_ssh_copykey_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_ssh_copykey_explain

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

  pbcopy <~/.ssh/$FILE

  echo -e "${GREEN}the key $FILE has been copied to your clipboard${NC}"

}

################################################################################
# Help                                                                        #
################################################################################

sajan_ssh_copykey_help() {
  echo -e "
  ${GREEN}copykey|c              ${NC}Read the public key of a key pair"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_ssh_copykey_explain() {
  echo -e "
  ${GREEN}sajan ssh copykey
  ${GREEN}s ssh c

  This command will execute the following commands${NC}

  ARRAY=\$(ls | grep pub))
  COUNT="0"
  DUMMYPUBKEY=1

  for i in \${ARRAY[*]}; do
    echo "[\$\(\(\$COUNT + 1\)\)] \$i"
    let COUNT++
  done

  read -p "Which key do you want to copy ? [\$DUMMYPUBKEY]: " PUBKEY
  PUBKEY=\${PUBKEY:-\$DUMMYPUBKEY}
  FILE=\${ARRAY[\$PUBKEY - 1]}

  pbcopy <  ~/.ssh/\$FILE

  ${YELLOW}This command will ask you which public key to copy and then copy it to clipboard${NC}

  Used tools for this action:
  - pbcopy

  "
  exit
}
