<?php

namespace Dietercoopman\SajanPhp;

use Dietercoopman\SajanPhp\Services\Configurator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;
use function Termwind\render;

class AICommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('ai')
            ->setDescription('Ask a question to the AI and get the command')
            ->addArgument('question', InputArgument::IS_ARRAY, 'The question you want to ask the AI');
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

        $questionParts = $input->getArgument('question');
        $question = implode(' ', $questionParts);
        if (empty($question)) {
            $question = 'What time is it?';
        }

        $command = $this->askOpenAI($input, $output, $question);

        //if the command includs the CHANGE| tag, set the command in red
        if (str_contains($command, 'CHANGE|')) {
            $color = 'yellow';
        } else {
            $color = 'green';
        }
        //replace the CHANGE| tag with an empty string
        $command = str_replace('CHANGE|', '', $command);

        $helper = $this->getHelper('question');

        //ask the user if the command can be executed and set the command in red
        $question = new Question('Can i run <fg='.$color.'>' . $command . '</> (y/n) ? ', true, '/^(y|j)/i');
        $answer = $helper->ask($input, $output, $question);

        //if the user wants to execute the command ( y , yes , j ), run it
        if ($answer == 'yes' or $answer == 'y' or $answer == 'j') {
            $this->runProcess($command, $output);
        }

        return 0;
    }


    function askOpenAI($input,$output,$prompt)
    {
        $apiKey = ((new Configurator())->getConfig()['openai']['key']) ?? null;
        if(!$apiKey){
            //ask for the api key
            $helper = $this->getHelper('question');
            $question = new Question('Please enter your OpenAI API key: ');
            $apiKey = $helper->ask($input, $output, $question);

            //store the api key
            $configurator = (new Configurator());
            $configurator->store('openai','key', $apiKey);
        }

        // API URL for OpenAI's Chat API
        $url = 'https://api.openai.com/v1/chat/completions';

        $clientOperatingSystem = php_uname('s');

        // The request data
        $data = [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are a Linux console on a {$clientOperatingSystem} computer. Only provide the command to execute, without explanations. If a command will change the system or a file, prefix it with 'CHANGE|'.",
                ],
                [
                    'role' => 'user',
                    'content' => $prompt, // The actual question from the user
                ],
            ],
            'max_tokens' => 150,  // Limit the response length
        ];

        // Initialize cURL session
        $ch = curl_init();

        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, $url); // API URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as string
        curl_setopt($ch, CURLOPT_POST, true); // Use POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,  // API key for authorization
            'Content-Type: application/json',    // Set content type to JSON
        ]);

        // Set the POST body (JSON-encoded request data)
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Execute the request and get the response
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        // Close the cURL session
        curl_close($ch);

        // Decode the JSON response
        $responseBody = json_decode($response, true);

        // Check if there's a valid response
        if (isset($responseBody['choices'][0]['message']['content'])) {
            // Return the assistant's response
            return $responseBody['choices'][0]['message']['content'];
        } else {
            return 'Error: Invalid response from API';
        }
    }
}
