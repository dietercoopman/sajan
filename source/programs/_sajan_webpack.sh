################################################################################
# Git                                                                          #
################################################################################

sajan_webpack() {
  ACTION=${ARGUMENTS[0]}

  case $ACTION in
  build)
    sajan_webpack_build
    exit
    ;;
  init)
    sajan_webpack_init
    exit
    ;;
  *)
    sajan_webpack_help
    exit
    ;;
  esac

}

################################################################################
# Test                                                                         #
################################################################################

sajan_webpack_test() {

  if ! node -v >/dev/null 2>&1; then
    echo -e "${RED}Node is not installed on your computer"
    nodeok=0
  else
    echo -e "${INFOCOLOR}Node is found on your computer"
    nodeok=1
  fi

  if ! npm -v >/dev/null 2>&1; then
    echo -e "${RED}Npm is not installed on your computer"
    npmok=0
  else
    echo -e "${INFOCOLOR}Npm is found on your computer"
    npmok=1
  fi

  return ${npmok} && ${nodeok}
}

################################################################################
# Help                                                                         #
################################################################################

sajan_webpack_help() {
  # Display Help
  echo -e "${YELLOW}Usage:${NC}"
  echo " sajan webpack [action]"
  echo
  echo -e "${YELLOW}Actions:"
  echo -e "  ${GREEN}init              ${NC}Init webpack for css and javascript in current directory"
  echo -e "  ${GREEN}build             ${NC}Build your assets"
  echo
  echo -e "${YELLOW}Options:"
  echo -e "  ${GREEN}-h     Print this Help."
  echo -e "  ${GREEN}-e     Explains the command via the dry-run output of the command."
  echo
  echo
}

################################################################################
# Init                                                                         #
################################################################################

sajan_webpack_init() {
  OPTION="${OPTIONS['h']}"
  if [ "$OPTION" = "h" ]; then
    echo -e "  ${GREEN}init              ${NC}Init webpack for css and javascript in current directory"
    echo -e "  ${INFOCOLOR}This action will create all necessary files for javascript and css compilation with webpack"
    exit
  fi

  if [ "$OPTION" = "e" ]; then
    echo -e "
  ${GREEN}sajan webpack init

  This command will execute the following commands${NC}

  package_config_string > package.json
  mkdir -p sass
  echo 'h1 { font-size: 25px; }' >sass/style.scss
  webpack_config_string >webpack.config.js
  npm install
  npm run build

  ${YELLOW}A configuration json for npm is saved to package.json. This file contains all necessary packages to install.
  A sass directory is created with a style.scss file.
  A webpack configuration file is created , this contains all webpack settings.
  Npm install will install all packages provided in package.json
  A build process is started to create the assets.${NC}
  "
    exit
  fi

  echo '{
  "private": true,
  "scripts": {
    "build": "webpack --mode development",
    "dist": "webpack --mode production",
    "watch": "webpack --watch --mode development"
  },
  "devDependencies": {
    "compass": "^0.1.1",
    "css-loader": "^5.0.1",
    "mini-css-extract-plugin": "^1.3.1",
    "node-sass": "^5.0.0",
    "sass-loader": "^10.1.0",
    "webpack": "^5.9.0",
    "webpack-cli": "^4.2.0"
  }
}
' >package.json
  mkdir -p sass
  echo "h1 {
  font-size: 25px;
}
" >sass/style.scss
  echo 'const path = require("path");

// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    devtool: false,
    entry: ["./sass/style.scss"],
    output: {
        path: path.resolve(__dirname)
    },
    module: {
        rules: [
            // compile all .scss files to plain old css
            {
                test: /\.(sass|scss)$/,
                use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"]
            }
        ]
    },

    plugins: [
        // extract css into dedicated file
        new MiniCssExtractPlugin({
            filename: "style.css"
        })
    ]
};' >webpack.config.js
  npm install
  npm run build
}

################################################################################
# Build                                                                         #
################################################################################

sajan_webpack_build() {

  OPTION="${OPTIONS['h']}"
  if [ "$OPTION" = "h" ]; then
    echo -e "  ${GREEN}build             ${NC}Build your assets"
    echo -e "  ${INFOCOLOR}This action will install all npm dependencies and run a build."
    exit
  fi

  if [ "$OPTION" = "e" ]; then
    echo -e "
  ${GREEN}sajan webpack build

  This command will execute the following commands${NC}

  npm install
  npm run build

  ${YELLOW}Install npm packages.  Build all assets${NC}
  "
    exit
  fi
  npm install
  npm run build
}
