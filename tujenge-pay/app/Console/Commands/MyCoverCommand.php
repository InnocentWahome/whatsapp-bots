<?php

namespace App\Console\Commands;


use Telegram\Bot\Commands\Command;


class MyCoverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = "mycover";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Get my cover information";


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle($arguments)
    {
        $this->replyWithMessage(['text' => 'Hello! Welcome to our bot, Here are our available commands:']);
    }
}
