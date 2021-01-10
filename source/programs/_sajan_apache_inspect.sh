################################################################################
# List                                                                        #
################################################################################

sajan_apache_inspect() {


  local UNIQUEID=${ARGUMENTS[1]}

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_apache_list_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_apache_list_explain


  if ! apachectl -v >/dev/null 2>&1; then
    echo -e "${RED}Apache is not installed on your system"
    return 0
  fi

  SITE="$(sajan apache list | grep ${UNIQUEID})"


  URL="$(echo "$SITE" | awk -v col=1 '{print $col}')"
  CONFIG="$(echo "$SITE" | awk -v col=2 '{print $col}')"

  TYPE="Unknown type"

  ISWORDPRESS="$(curl -s ${URL} | grep 'wp-includes')"
  if [ "$ISWORDPRESS" != "" ]; then
    echo "Wordpress site"
    TYPE="Worpress site"
  fi

  ISLARAVEL="$(curl -X HEAD -i -s  ${URL} | grep 'laravel')"
  if [ "$ISLARAVEL" != "" ]; then
    TYPE="Laravel site"
  fi

  CONFIGCOLS=${CONFIG//:/ }
  CONFIGFILE="$(echo ${CONFIGCOLS} | awk -v col=1 '{print $col}')"
  CONFIGLINE="$(echo ${CONFIGCOLS} | awk -v col=2 '{print $col}')"
  DOCUMENTROOT="$(head -n ${CONFIGLINE} ${CONFIGFILE}| tail -1)"
  DOCUMENTROOT=${DOCUMENTROOT//DocumentRoot /}

  echo -e "Site type: ${GREEN}${TYPE}${NC}"
  echo -e "Url: ${GREEN}${URL}${NC}"
  echo -e "Apache config file: ${GREEN}${CONFIGFILE}${NC}"
  echo -e "Config on line: ${GREEN}${CONFIGLINE}${NC}"
  echo -e "Document root: ${GREEN}${DOCUMENTROOT}${NC}"

}

################################################################################
# Help                                                                        #
################################################################################

sajan_apache_inspect_help() {
  echo -e "
  ${GREEN}inspect|i [uniqueid]     ${NC}Get more details for a given site , like vhost , source path, application type, database${NC}"
  echo
  exit
}

################################################################################
# Explain                                                                        #
################################################################################

sajan_apache_inspect_explain() {
  echo -e "
  ${GREEN}sajan apache inspect [uniqueid]
  ${GREEN}s apache i [uniqueid]

  This command will execute the following commands and format its output in a table${NC}

  It wil run 'sajan apache list' and find the specified site van the provided uniqueid.  The script will
  check the headers or the content of the site to determine which site type the site is.  Wordpress and Laravel sites are working for the moment.
  The script also checks the apache config to get the document root and the configfile and line of where the vhost is configured.

  ${YELLOW}...${NC}

  Used tools for this action:
  - apachectl

  "
  exit
}
