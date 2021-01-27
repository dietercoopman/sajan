
################################################################################
# Init                                                                         #
################################################################################

sajan_webpack_init() {

  fn_array_contains "h" "${OPTIONS[@]}" && sajan_webpack_init_help
  fn_array_contains "e" "${OPTIONS[@]}" && sajan_webpack_init_explain

  echo '{
  "private": true,
  "scripts": {
    "build": "webpack --mode development",
    "dist": "webpack --mode production",
    "watch": "webpack --watch --mode development",
    "wp": "webpack --watch --mode production"
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
  touch sass/style.scss

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
# Help                                                                         #
################################################################################

sajan_webpack_init_help() {
  echo -e "  ${GREEN}init|i              ${NC}Init webpack for css and javascript in current directory"
  echo -e "  ${INFOCOLOR}This action will create all necessary files for javascript and css compilation with webpack"
  echo
  exit
}


################################################################################
# Explain                                                                      #
################################################################################

sajan_webpack_init_explain() {

  echo -e "
  ${GREEN}sajan webpack init
  ${GREEN}s webpack i

  This command will execute the following commands${NC}

  package_config_string > package.json
  mkdir -p sass
  echo 'h1 { font-size: 25px; }' > sass/style.scss
  webpack_config_string > webpack.config.js
  npm install
  npm run build

  ${YELLOW}A configuration json for npm is saved to package.json. This file contains all necessary packages to install.
  A sass directory is created with a style.scss file.
  A webpack configuration file is created , this contains all webpack settings.
  Npm install will install all packages provided in package.json
  A build process is started to create the assets.${NC}

  Used tools for this action:
  - node
  - npm

  "
  exit
}
