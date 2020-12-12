
################################################################################
################################################################################
# Main program                                                                 #
################################################################################

fn_exists() {
  # appended double quote is an ugly trick to make sure we do get a string -- if $1 is not a known command, type does not output anything
  [ $(type -t $1)"" == 'function' ]
}


fn_invalid() {
  Info
  Version
  echo
  Help
  exit
}

################################################################################
# Process the input options. Add options as needed.                            #
################################################################################
# Get the options
while getopts ":hvi" option; do
  case $option in
  h) # display Help
    Help
    exit
    ;;
  v) #display version
    Version
    exit
    ;;
  i) #display info
    Info
    exit
    ;;
  \?) # incorrect option
    Help
    exit
    ;;
  esac
done

# Get the program
PROGRAM="$1"
EXEC="sajan_$PROGRAM"

if [[ $PROGRAM == "" ]]; then
  fn_invalid
fi

if ! fn_exists $EXEC; then
  fn_invalid
fi

$EXEC "$2" "$3" "$4"

