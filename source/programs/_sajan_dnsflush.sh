################################################################################
# dnsflush                                                                        #
################################################################################

sajan_dnsflush() {
  fn_array_contains "h" "${OPTIONS[@]}" && sajan_dnsflush_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_dnsflush_explain

  sudo killall -HUP mDNSResponder

}


################################################################################
# Help                                                                        #
################################################################################

sajan_dnsflush_help() {
  echo -e "
  ${GREEN}dnsflush              ${NC}Clear the dns cache of your computer"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_dnsflush_explain() {
  echo -e "
  ${GREEN}sajan dnsflush

  This command will execute the following commands${NC}

  sudo killall -HUP mDNSResponder

"
  exit
}
