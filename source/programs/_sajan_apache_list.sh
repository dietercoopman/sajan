################################################################################
# List                                                                        #
################################################################################

sajan_apache_list() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_apache_list_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_apache_list_explain

  INPUT="$(apache2ctl -S | grep namevhost)"
  INPUT=${INPUT//namevhost /}

  INPUT=${INPUT//         port /}
  echo "$INPUT" |
    while IFS= read -r line; do
      line=${line//443 /https://}
      line=${line//80 /https://}

      URL="$(echo "$line" | cut -d' ' -f 1)"

      CONFIG="$(echo "$line" | cut -d' ' -f 2)"
      CONFIG=${CONFIG//(/}
      CONFIG=${CONFIG//)/}
      CONFIGFILE="$(echo "$CONFIG" | cut -d':' -f 1)"

      LINENUMBER="$(echo "$CONFIG" | cut -d':' -f 2)"
      LINENUMBER=$((LINENUMBER+1))

      echo "$URL"
      #$CONFIGFILE $LINENUMBER
      #sed "$LINENUMBER!d" "$CONFIGFILE"

    done

}

################################################################################
# Help                                                                        #
################################################################################

sajan_apache_list_help() {
  echo -e "
  ${GREEN}list|             ${NC}List all active sites on your system${NC}"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_apache_list_explain() {
  echo -e "
  ${GREEN}sajan apache list
  ${GREEN}s apache l

  This command will execute the following commands${NC}


  ${YELLOW}...${NC}

  Used tools for this action:
  - apachectl

  "
  exit
}
