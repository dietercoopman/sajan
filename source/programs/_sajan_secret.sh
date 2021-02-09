################################################################################
# secret                                                                        #
################################################################################

sajan_secret() {
  fn_array_contains "h" "${OPTIONS[@]}" && sajan_secret_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_secret_explain

  echo "I'll give you a little secret: "
  SECRET=$(openssl rand -base64 32)
  echo -e "${GREEN}$SECRET${NC}"

}


################################################################################
# Help                                                                        #
################################################################################

sajan_secret_help() {
  echo -e "
  ${GREEN}secret              ${NC}Let sajan create you a secure password"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_secret_explain() {
  echo -e "
  ${GREEN}sajan secret

  This command will execute the following commands${NC}

  openssl rand -base64 32

  Used tools for this action:
  - openssl

"
  exit
}
