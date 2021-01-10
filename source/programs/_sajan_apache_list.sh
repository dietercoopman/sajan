################################################################################
# List                                                                        #
################################################################################

sajan_apache_list() {


  local SEARCH=${ARGUMENTS[1]}

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_apache_list_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_apache_list_explain


  if ! apachectl -v >/dev/null 2>&1; then
    echo -e "${RED}Apache is not installed on your system"
    return 0
  fi

  if [ "$SEARCH" != "" ]; then
    INPUT="$(apache2ctl -S | grep namevhost | grep ${SEARCH})"
  else
    INPUT="$(apache2ctl -S | grep namevhost)"
  fi


  INPUT=${INPUT//namevhost /}

  echo -e "Hostname|Configuration file|Unique id" > /tmp/sajan_apache_list.txt

  INPUT=${INPUT//         port /}
  echo "$INPUT" |
    while IFS= read -r line; do
      line=${line//443 /https://}
      line=${line//80 /http://}

      URL="$(echo "$line" | cut -d' ' -f 1)"

      CONFIG="$(echo "$line" | cut -d' ' -f 2)"
      CONFIG=${CONFIG//(/}
      CONFIG=${CONFIG//)/}
      CONFIGFILE="$(echo "$CONFIG" | cut -d':' -f 1)"

      LINENUMBER="$(echo "$CONFIG" | cut -d':' -f 2)"
      LINENUMBER=$((LINENUMBER+1))

      UNIQUEID="$(echo "$URL" | md5sum)"
      UNIQUEID=${UNIQUEID//-/}

      echo -e "$URL|$CONFIGFILE:$LINENUMBER|$UNIQUEID" >> /tmp/sajan_apache_list.txt

    done
      sort  /tmp/sajan_apache_list.txt > /tmp/sajan_apache_list_sorted.txt
      column -t -s '|' /tmp/sajan_apache_list_sorted.txt
      rm /tmp/sajan_apache_list.txt
      rm /tmp/sajan_apache_list_sorted.txt

}

################################################################################
# Help                                                                        #
################################################################################

sajan_apache_list_help() {
  echo -e "
  ${GREEN}list|l [site]            ${NC}List all active sites on your system, and optional search for a site${NC}"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_apache_list_explain() {
  echo -e "
  ${GREEN}sajan apache list [site]
  ${GREEN}s apache l

  This command will execute the following commands and format its output in a table${NC}

  apache2ctl -S | grep namevhost

  ${YELLOW}...${NC}

  Used tools for this action:
  - apachectl

  "
  exit
}
