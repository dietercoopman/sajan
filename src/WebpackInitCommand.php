<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WebpackInitCommand extends BaseCommand
{

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('webpack:init')
            ->setDescription('Init webpack for css and javascript in current directory')
            ->setAliases(['wi']);
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $progressBar = new ProgressBar($output, 100);
        $progressBar->start();
        $output->writeln('');

        $this->createPackageJson();
        $progressBar->advance(10);

        $this->runProcess('mkdir -p sass', $output, $progressBar, 10);
        $this->runProcess('touch sass/style.scss', $output, $progressBar, 10);

        $this->createWebpackConfig();
        $progressBar->advance(10);

        $this->runProcess('npm install', $output, $progressBar, 25);
        $this->runProcess('npm run build', $output, $progressBar, 35);

        $progressBar->finish();

        return 0;
    }

    public function createPackageJson()
    {
        $json = '
{
  "private": true,
  "scripts": {
        "build": "webpack --mode development",
        "dist": "webpack --mode production",
        "watch": "webpack --watch --mode development",
        "wp": "webpack --watch --mode production"
  },
  "devDependencies": {
        "css-loader": "^6.2.1",
        "mini-css-extract-plugin": "^2.3.0",
        "node-sass": "^6.0.0",
        "sass": "^1.38.1",
        "sass-loader": "^12.0.0",
        "webpack": "^5.9.0",
        "webpack-cli": "^4.2.0"
  }
}';
        file_put_contents('package.json', $json);
    }

    public function createWebpackConfig()
    {
        $output = 'const path = require("path");
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
};';
        file_put_contents('webpack.config.js', $output);
    }


}
