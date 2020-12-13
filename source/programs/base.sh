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
declare -a ARGUMENTS=()
declare -a OPTIONS=()

for var in "$@"; do
  if [[ ${var:0:1} == "-" ]]; then
    OPTIONS=("${OPTIONS[@]}" ${var:1})
  else
    ARGUMENTS=("${ARGUMENTS[@]}" $var)
  fi
done

# If no arguments passed then check the base options
if [ "${#ARGUMENTS[@]}" -eq "0" ]; then

  for option in ${OPTIONS[@]}; do

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
fi

# Get the program
PROGRAM=${ARGUMENTS[0]}
# remove program from arguments array
ARGUMENTS=("${ARGUMENTS[@]:1}")

EXEC="sajan_$PROGRAM"
if [[ $PROGRAM == "" ]]; then
  fn_invalid
fi

if ! fn_exists $EXEC; then
  fn_invalid
fi

$EXEC
