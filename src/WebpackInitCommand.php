<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class WebpackInitCommand extends Command
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('webpack:init')
            ->setDescription('Init webpack for css and javascript in current directory');
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
        $this->createPackageJson();
        Process::fromShellCommandline('mkdir -p sass &&  touch sass/style.scss')->mustRun()->getOutput();

        $this->createWebpackConfig();

        $process = Process::fromShellCommandline('npm install && npm run build');
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });

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
        "compass": "^0.1.1",
        "css-loader": "^5.0.1",
        "mini-css-extract-plugin": "^1.3.1",
        "node-sass": "^5.0.0",
        "sass": "^1.38.1",
        "sass-loader": "^10.1.0",
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
