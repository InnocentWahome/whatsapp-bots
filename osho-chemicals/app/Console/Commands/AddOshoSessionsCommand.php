<?php

namespace App\Console\Commands;

use App\Models\BotSession;
use App\Models\BotResponse;
use App\Models\BotSessionStep;
use Illuminate\Console\Command;

class AddOshoSessionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:osho-bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bot_sessions = [
            [
                'session_name' => 'osho',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 0,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hi👋🏽, Welcome to Osho Digital Assistant, please type\nin the number of your county location.\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'service_methods' => [
                            [
                                'method_name' => 'Registration',
                                'method_type' => 'registration',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => "1. Bungoma\n2. Nyeri\n3. Kilifi\n4. Narok\n5. Trans Nzoia\n6. Kakamega\n7. Baringo\n8. Nairobi\n9. Kajiado\n10. Meru\n11. Tharaka Nithi\n12. Kisumu\n13. Homa Bay\n14. Nakuru\n15. Kiambu\n16. Tana River\n17. Kitui\n18. Kericho\n19. Elgeyo Marakwet\n20. Laikipia\n21. Kisii\n22. Nyandarua\n23. Migori\n24. Kirinyaga\n25. Vihiga\n26. Embu\n27. Makueni\n28. Bomet\n29. Mombasa\n30. Nandi\n31. West Pokot\n32. Busia\n33. Uasin Gishu\n34. Nyamira\n35. Muranga\n36. Machakos\n37. Taita Taveta\n38. Siaya\n39. Isiolo\n40. Garissa\n41. Kwale\n\nType in the number of your county location.",
                                'show_step_id' => 0,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Hi👋🏽, Welcome to Osho chemicals. How may we help you? Type in the number to select an option below to start.👇🏾\n\n",
                        'next_session_step' => 2,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'service_methods' => [
                            [
                                'method_name' => 'getStart',
                                'method_type' => 'get_start',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => 'About Osho',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'response_text' => 'Crop Protection',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'response_text' => 'Animal Health',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'response_text' => 'Find an Agrovet',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'response_text' => 'Contact Osho Chemical Industries Ltd',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'response_text' => 'Customer Satisfaction Survey',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ]
                ]
            ],
            [
                'session_name' => '99',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 0,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hi👋🏽, Welcome to Osho chemicals. How may we help you? Type in the number to select an option below to start.👇🏾\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'service_methods' => [
                            [
                                'method_name' => 'Home',
                                'method_type' => 'home',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => 'About Osho',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'response_text' => 'Crop Protection',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'response_text' => 'Animal Health',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'response_text' => 'Find an Agrovet',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'response_text' => 'Contact Osho Chemical Industries Ltd',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'response_text' => 'Customer Satisfaction Survey',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ]
                ]
            ],
            [
                'session_name' => 'hi',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 0,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hi👋🏽, Welcome to Osho Digital Assistant, please type\nin the number of your county location.\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'service_methods' => [
                            [
                                'method_name' => 'Registration',
                                'method_type' => 'registration',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => "1. Bungoma\n2. Nyeri\n3. Kilifi\n4. Narok\n5. Trans Nzoia\n6. Kakamega\n7. Baringo\n8. Nairobi\n9. Kajiado\n10. Meru\n11. Tharaka Nithi\n12. Kisumu\n13. Homa Bay\n14. Nakuru\n15. Kiambu\n16. Tana River\n17. Kitui\n18. Kericho\n19. Elgeyo Marakwet\n20. Laikipia\n21. Kisii\n22. Nyandarua\n23. Migori\n24. Kirinyaga\n25. Vihiga\n26. Embu\n27. Makueni\n28. Bomet\n29. Mombasa\n30. Nandi\n31. West Pokot\n32. Busia\n33. Uasin Gishu\n34. Nyamira\n35. Muranga\n36. Machakos\n37. Taita Taveta\n38. Siaya\n39. Isiolo\n40. Garissa\n41. Kwale\n\nType in the number of your county location.",
                                'show_step_id' => 0,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Hi👋🏽, Welcome to Osho chemicals. How may we help you? Type in the number to select an option below to start.👇🏾\n\n",
                        'next_session_step' => 2,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'service_methods' => [
                            [
                                'method_name' => 'getStart',
                                'method_type' => 'get_start',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => 'About Osho',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'response_text' => 'Crop Protection',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'response_text' => 'Animal Health',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'response_text' => 'Find an Agrovet',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'response_text' => 'Contact Osho Chemical Industries Ltd',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'response_text' => 'Customer Satisfaction Survey',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ]
                ]
            ],
            [
                'session_name' => 'hey',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 0,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hi👋🏽, Welcome to Osho Digital Assistant, please type\nin the number of your county location.\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'service_methods' => [
                            [
                                'method_name' => 'Registration',
                                'method_type' => 'registration',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => "1. Bungoma\n2. Nyeri\n3. Kilifi\n4. Narok\n5. Trans Nzoia\n6. Kakamega\n7. Baringo\n8. Nairobi\n9. Kajiado\n10. Meru\n11. Tharaka Nithi\n12. Kisumu\n13. Homa Bay\n14. Nakuru\n15. Kiambu\n16. Tana River\n17. Kitui\n18. Kericho\n19. Elgeyo Marakwet\n20. Laikipia\n21. Kisii\n22. Nyandarua\n23. Migori\n24. Kirinyaga\n25. Vihiga\n26. Embu\n27. Makueni\n28. Bomet\n29. Mombasa\n30. Nandi\n31. West Pokot\n32. Busia\n33. Uasin Gishu\n34. Nyamira\n35. Muranga\n36. Machakos\n37. Taita Taveta\n38. Siaya\n39. Isiolo\n40. Garissa\n41. Kwale\n\nType in the number of your county location.",
                                'show_step_id' => 0,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Hi👋🏽, Welcome to Osho chemicals. How may we help you? Type in the number to select an option below to start.👇🏾\n\n",
                        'next_session_step' => 2,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'service_methods' => [
                            [
                                'method_name' => 'getStart',
                                'method_type' => 'get_start',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => 'About Osho',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'response_text' => 'Crop Protection',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'response_text' => 'Animal Health',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'response_text' => 'Find an Agrovet',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'response_text' => 'Contact Osho Chemical Industries Ltd',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'response_text' => 'Customer Satisfaction Survey',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ]
                ]
            ],
            [
                'session_name' => 'hello',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 0,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hi👋🏽, Welcome to Osho Digital Assistant, please type\nin the number of your county location.\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'service_methods' => [
                            [
                                'method_name' => 'Registration',
                                'method_type' => 'registration',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => "1. Bungoma\n2. Nyeri\n3. Kilifi\n4. Narok\n5. Trans Nzoia\n6. Kakamega\n7. Baringo\n8. Nairobi\n9. Kajiado\n10. Meru\n11. Tharaka Nithi\n12. Kisumu\n13. Homa Bay\n14. Nakuru\n15. Kiambu\n16. Tana River\n17. Kitui\n18. Kericho\n19. Elgeyo Marakwet\n20. Laikipia\n21. Kisii\n22. Nyandarua\n23. Migori\n24. Kirinyaga\n25. Vihiga\n26. Embu\n27. Makueni\n28. Bomet\n29. Mombasa\n30. Nandi\n31. West Pokot\n32. Busia\n33. Uasin Gishu\n34. Nyamira\n35. Muranga\n36. Machakos\n37. Taita Taveta\n38. Siaya\n39. Isiolo\n40. Garissa\n41. Kwale\n\nType in the number of your county location.",
                                'show_step_id' => 0,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Hi👋🏽, Welcome to Osho chemicals. How may we help you? Type in the number to select an option below to start.👇🏾\n\n",
                        'next_session_step' => 2,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'service_methods' => [
                            [
                                'method_name' => 'getStart',
                                'method_type' => 'get_start',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => 'About Osho',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'response_text' => 'Crop Protection',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'response_text' => 'Animal Health',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'response_text' => 'Find an Agrovet',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'response_text' => 'Contact Osho Chemical Industries Ltd',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'response_text' => 'Customer Satisfaction Survey',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ]
                ]
            ],
            [
                'session_name' => 'jambo',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 0,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hi👋🏽, Welcome to Osho Digital Assistant, please type\nin the number of your county location.\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'service_methods' => [
                            [
                                'method_name' => 'Registration',
                                'method_type' => 'registration',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => "1. Bungoma\n2. Nyeri\n3. Kilifi\n4. Narok\n5. Trans Nzoia\n6. Kakamega\n7. Baringo\n8. Nairobi\n9. Kajiado\n10. Meru\n11. Tharaka Nithi\n12. Kisumu\n13. Homa Bay\n14. Nakuru\n15. Kiambu\n16. Tana River\n17. Kitui\n18. Kericho\n19. Elgeyo Marakwet\n20. Laikipia\n21. Kisii\n22. Nyandarua\n23. Migori\n24. Kirinyaga\n25. Vihiga\n26. Embu\n27. Makueni\n28. Bomet\n29. Mombasa\n30. Nandi\n31. West Pokot\n32. Busia\n33. Uasin Gishu\n34. Nyamira\n35. Muranga\n36. Machakos\n37. Taita Taveta\n38. Siaya\n39. Isiolo\n40. Garissa\n41. Kwale\n\nType in the number of your county location.",
                                'show_step_id' => 0,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Hi👋🏽, Welcome to Osho chemicals. How may we help you? Type in the number to select an option below to start.👇🏾\n\n",
                        'next_session_step' => 2,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'service_methods' => [
                            [
                                'method_name' => 'getStart',
                                'method_type' => 'get_start',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => 'About Osho',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'response_text' => 'Crop Protection',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'response_text' => 'Animal Health',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'response_text' => 'Find an Agrovet',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'response_text' => 'Contact Osho Chemical Industries Ltd',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'response_text' => 'Customer Satisfaction Survey',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ]
                ]
            ],
            [
                'session_name' => 'sasa',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 0,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hi👋🏽, Welcome to Osho Digital Assistant, please type\nin the number of your county location.\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'service_methods' => [
                            [
                                'method_name' => 'Registration',
                                'method_type' => 'registration',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => "1. Bungoma\n2. Nyeri\n3. Kilifi\n4. Narok\n5. Trans Nzoia\n6. Kakamega\n7. Baringo\n8. Nairobi\n9. Kajiado\n10. Meru\n11. Tharaka Nithi\n12. Kisumu\n13. Homa Bay\n14. Nakuru\n15. Kiambu\n16. Tana River\n17. Kitui\n18. Kericho\n19. Elgeyo Marakwet\n20. Laikipia\n21. Kisii\n22. Nyandarua\n23. Migori\n24. Kirinyaga\n25. Vihiga\n26. Embu\n27. Makueni\n28. Bomet\n29. Mombasa\n30. Nandi\n31. West Pokot\n32. Busia\n33. Uasin Gishu\n34. Nyamira\n35. Muranga\n36. Machakos\n37. Taita Taveta\n38. Siaya\n39. Isiolo\n40. Garissa\n41. Kwale\n\nType in the number of your county location.",
                                'show_step_id' => 0,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Hi👋🏽, Welcome to Osho chemicals. How may we help you? Type in the number to select an option below to start.👇🏾\n\n",
                        'next_session_step' => 2,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'service_methods' => [
                            [
                                'method_name' => 'getStart',
                                'method_type' => 'get_start',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => 'About Osho',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'response_text' => 'Crop Protection',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'response_text' => 'Animal Health',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'response_text' => 'Find an Agrovet',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'response_text' => 'Contact Osho Chemical Industries Ltd',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'response_text' => 'Customer Satisfaction Survey',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ]
                ]
            ],
            [
                'session_name' => 'mambo',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 0,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hi👋🏽, Welcome to Osho Digital Assistant, please type\nin the number of your county location.\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'service_methods' => [
                            [
                                'method_name' => 'Registration',
                                'method_type' => 'registration',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => "1. Bungoma\n2. Nyeri\n3. Kilifi\n4. Narok\n5. Trans Nzoia\n6. Kakamega\n7. Baringo\n8. Nairobi\n9. Kajiado\n10. Meru\n11. Tharaka Nithi\n12. Kisumu\n13. Homa Bay\n14. Nakuru\n15. Kiambu\n16. Tana River\n17. Kitui\n18. Kericho\n19. Elgeyo Marakwet\n20. Laikipia\n21. Kisii\n22. Nyandarua\n23. Migori\n24. Kirinyaga\n25. Vihiga\n26. Embu\n27. Makueni\n28. Bomet\n29. Mombasa\n30. Nandi\n31. West Pokot\n32. Busia\n33. Uasin Gishu\n34. Nyamira\n35. Muranga\n36. Machakos\n37. Taita Taveta\n38. Siaya\n39. Isiolo\n40. Garissa\n41. Kwale\n\nType in the number of your county location.",
                                'show_step_id' => 0,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Hi👋🏽, Welcome to Osho chemicals. How may we help you? Type in the number to select an option below to start.👇🏾\n\n",
                        'next_session_step' => 2,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'service_methods' => [
                            [
                                'method_name' => 'getStart',
                                'method_type' => 'get_start',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => 'About Osho',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'response_text' => 'Crop Protection',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'response_text' => 'Animal Health',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'response_text' => 'Find an Agrovet',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'response_text' => 'Contact Osho Chemical Industries Ltd',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'response_text' => 'Customer Satisfaction Survey',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ]
                ]
            ],

            [
                'session_name' => 'about_us',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 1,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Osho Chemical Industries Ltd are the leading Manufacturer, marketer and distributor of Crop protection, Animal Health Products, Public Health, Industrial Chemicals, Farm Equipment, allied products and services.\n\n*Our Mission*\n\nTo provide quality and affordable life science, industrial, farm equipment and allied products and services in East, Central and Southern Africa.\n\n*Our Vision*\n\nTo be the best in what we do!\n\n*Our Core Values*\nG – Growth by ensuring customer success\nR – Reliability and Integrity in what we do\nO – Opportunity adept and lnnovativeness\nW – Wealth Creation, Knowledge & Prosperity across the value chain\nT – Team work\nH – Health and safety\n\nType *99* to go back home",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'with_input' => 0,
                        'responses' => []
                    ]
                ]
            ],
            [
                'session_name' => 'crop_protection',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 2,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Jambo profilename which crop are you growing or intend to grow?\n\n",
                        'next_session_step' => 8,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'service_methods' => [
                            //    [
                            //        'method_name' => 'sendEmail',
                            //        'method_type' => 'send_email',
                            //    ]
                        ],
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => 'Tomatoes',
                                'next_session_step' => 8
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Talk to an agent\n\nType *99* to go back home",
                                'next_session_step' => 1
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Please type your enquiry below👇🏾and one of our customer care agents will get back to you shortly.\n\nType *0* to go back one step\nType *99* to go back home",
                        'next_session_step' => 2000,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'service_methods' => [
                            [
                                'method_name' => 'sendEmail',
                                'method_type' => 'send_email',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            //    [
                            //        'channel' => 'WA',
                            //        'key_word' => 1,
                            //        'show_step_id' => 0,
                            //        'response_text' => '',
                            //        'next_session_step' => 2000
                            //    ]
                        ]
                    ],
                    //                    [
                    //                        'channel' => 'WA',
                    //                        'is_initial_step' => false,
                    //                        'session_step' => 2,
                    //                        'step_title' => "",
                    //                        'next_session_step' => 3,
                    //                        'back_to_session' => false,
                    //                        'previous_session_name' => null,
                    //                        'allow_back' => true,
                    //                        'previous_session_step' => 0,
                    //                        'service_methods' => [
                    //                            [
                    //                                'method_name' => 'getProduct',
                    //                                'method_type' => 'get_product',
                    //                            ]
                    //                        ],
                    //                        'with_input' => 0,
                    //                        'responses' => [
                    //                            [
                    //                                'channel' => 'WA',
                    //                                'key_word' => 1,
                    //                                'show_step_id' => 0,
                    //                                'response_text' => '',
                    //                                'next_session_step' => 3
                    //                            ]
                    //                        ]
                    //                    ],
                    //                    [
                    //                        'channel' => 'WA',
                    //                        'is_initial_step' => false,
                    //                        'session_step' => 3,
                    //                        'step_title' => "Do you want to continue ?\n",
                    //                        'next_session_step' => 4,
                    //                        'back_to_session' => false,
                    //                        'previous_session_name' => null,
                    //                        'allow_back' => true,
                    //                        'previous_session_step' => 2,
                    //                        'with_input' => 1,
                    //                        'responses' => [
                    //                            [
                    //                                'channel' => 'WA',
                    //                                'key_word' => 1,
                    //                                'show_step_id' => 1,
                    //                                'response_text' => 'Yes',
                    //                                'next_session_step' => 4
                    //                            ],
                    //                            [
                    //                                'channel' => 'WA',
                    //                                'key_word' => 2,
                    //                                'show_step_id' => 1,
                    //                                'response_text' => 'No',
                    //                                'next_session_step' => 5
                    //                            ]
                    //
                    //                        ]
                    //                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 8,
                        'step_title' => "At what stage are your tomatoes?\n\n",
                        'next_session_step' => 9,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Nursery stage",
                                'next_session_step' => 9
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Land preparation",
                                'next_session_step' => 14
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => "Transplanting stage",
                                'next_session_step' => 20
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'show_step_id' => 1,
                                'response_text' => "Vegetative stage",
                                'next_session_step' => 25
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'show_step_id' => 1,
                                'response_text' => "Flowering stage",
                                'next_session_step' => 31
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'show_step_id' => 1,
                                'response_text' => "Fruiting stage",
                                'next_session_step' => 36
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 7,
                                'show_step_id' => 1,
                                'response_text' => "Harvesting stage\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 41
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 9,
                        'step_title' => "Please reply with a number below to know more.\n\n",
                        'next_session_step' => 10,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 8,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Information",
                                'next_session_step' => 10
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Pests & Diseases\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 11
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 10,
                        'step_title' => "Tomatoes can be established through the nursery or directly seeded. Normally, it is raised in the nursery before transplanting. The seed rate is about 40 – 75 g/acre\nSeed trays can also be used to raise seedlings\n\n*Nursery Site Selection*:\nThe nursery should be sited in a plot that has not been planted with a member of Solanaceae family for the last 3 years. Choose a site with good drainage.\n*Nursery Establishment:*\nPrepare a nursery bed of 1 m width and of a convenient length.\nMake drills on the nursery bed at a spacing of 10 – 20 cm apart.\nThinly sow the seeds in the drills and cover lightly with soil.\n\n*Management of Nursery:*\nWater the nursery regularly.\nHarden the seedlings 1 – 2 weeks before transplanting by reducing the frequency of watering and gradually exposing the seedlings to direct sunlight.\nInsects such as whiteflies can transmit viruses to young tomato plants hence should be controlled using FINAL FLIGHT, PROTEST.",
                        'next_session_step' => 12,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 9,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 46
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 11,
                        'step_title' => "",
                        'next_session_step' => 13,
                        'reply_type' => 'inline_buttons',
                        'button_header_type' => 'image',
                        'is_next_step_session' => true,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 9,
                        'next_session' => 'agrovet',
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/damping-off.png",
                                'response_text' => "*Damping-off*\n\nIt is a soil borne disease caused by several types of fungi affecting seedlings. It causes rotting of the seedling stems just above the soil line resulting in wilting, falling and death of the seedlings. If not controlled, it can result to 100% loss of seedlings, poor or no germination of seeds.\n*SOLUTION.*\nDrench the nursery with MATCO 72WP (50g/20L), MISTRESS 72WP (40g/20L), COMPANION 74WP (30g/20L).",
                                'next_session_step' => 13,
                                'is_next_step_session' => true,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/nematodes.png",
                                'response_text' => "*Nematodes*\n\nNematodes are soil borne worms which attack plant roots. They get into vascular bundles of the roots via root tip. They multiply and feed on inside of the roots causing galls hampering water and nutrient uptake resulting in stunted growth, wilting and eventual death of plants. If not controlled, can cause serious loss in yield.\n*SOLUTION*\nDrench BIONEMATON LIQUID (100mls/20L), NIMBECIDINE (100mls/20L).",
                                'next_session_step' => 13,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/tuta-absoluta.jpg",
                                'response_text' => "*Tuta Absoluta*\n\nThis moth is grey-brown, same size and posture as diamond back moth (DBM) and has a long antenna.\nThe Pupa is light brown.\nThe larva (caterpillar) is the damaging stage.\nIt bores on fruits, leaving symptomatic tiny holes.\nIt also burrows on stems causing breakages.\nCan lead to 100% crop loss.\n*SOLUTION.*\nEarly control is important before the pest pressure builds up\nUse PASSWORD 57WDG® 4gms/20L, FIREWORKS 90SC® 10mls/20L, RELAY 150SC® 5mls/20L.",
                                'next_session_step' => 13,
                                'next_session' => 'agrovet'
                            ],
                            //                            [
                            //                                'channel' => 'WA',
                            //                                'key_word' => 2,
                            //                                'show_step_id' => 0,
                            //                                'image_url' => "https://api1.sasa.ai/images/leaf-miners.jpg",
                            //                                'response_text' => "*Leaf Miners*\n\nThe females lay the eggs below the leaf surface. When they hatch, they eat through the inside of the leaf, leaving tell-tale white lines on tomato leaves.\n*SOLUTION.*\nIt can be controlled by using CLIMB 18EC 10mls/20L, FIREWORKS 90SC 10mls/20L, RELAY 150SC® 5mls/20L.\n\nType *0* to go back one step\nType *99* to go back home",
                            //                                'next_session_step' => 13,
                            //                                'next_session' => 'agrovet'
                            //                            ]
                            [
                                'channel' => 'WA',
                                'key_word' => 30000000000,
                                'show_step_id' => 0,
                                'image_url' => "",
                                'response_text' => "To load more",
                                'next_session_step' => 46,
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 46,
                        'step_title' => "",
                        'next_session_step' => 13,
                        'reply_type' => 'inline_buttons',
                        'button_header_type' => 'image',
                        'is_next_step_session' => true,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 9,
                        'next_session' => 'agrovet',
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/leaf-miners.jpg",
                                'response_text' => "*Leaf Miners*\n\nThe females lay the eggs below the leaf surface. When they hatch, they eat through the inside of the leaf, leaving tell-tale white lines on tomato leaves.\n*SOLUTION.*\nIt can be controlled by using CLIMB 18EC 10mls/20L, FIREWORKS 90SC 10mls/20L, RELAY 150SC® 5mls/20L.\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 13,
                                'next_session' => 'agrovet'
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 14,
                        'step_title' => "Please reply with a number below to know more.\n\n",
                        'next_session_step' => 15,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 8,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Information",
                                'next_session_step' => 15
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Pests & Diseases",
                                'next_session_step' => 18
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 15,
                        'step_title' => "*Manure application:*\n\nThe manure/compost should be broadcasted (5 – 8 tons/acre) then worked into the soil (incorporated) preferably using a hoe.\nManure/compost should be applied 1 – 2 weeks before transplanting the Tomato.",
                        'next_session_step' => 17,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 14,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 17
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 18,
                        'step_title' => "",
                        'next_session_step' => 19,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 14,
                        'reply_type' => 'inline_buttons',
                        'button_header_type' => 'text',
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "*Clearing weeds*\n\nWeeds can be cleared through ploughing. However, if opting for minimum tillage, you can clear the weeds using herbicides. Use KICKOUT 480SL at 200mls/20L.",
                                'next_session_step' => 19,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'response_text' => "*Amending the soil*\n\nTomato requires a well-drained soil that can allow optimum uptake of nutrients and water. Soil tends to adsorb some minerals required by the tomato. For instance, phosphorous is firmly absorbed and needs an amendment product to make such nutrients available for tomato uptake. Use BLACK EARTH 85WSG at 1-2kg/Acre.\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 19,
                                'next_session' => 'agrovet'
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 20,
                        'step_title' => "Please reply with a number below to know more.\n\n",
                        'next_session_step' => 21,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 8,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Information",
                                'next_session_step' => 21
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Pests & Diseases",
                                'next_session_step' => 22
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 21,
                        'step_title' => "*Appropriate Time:*\n\nSeedlings are transplanted 30 – 45 days after seed sowing in the nursery bed.\nIt is recommended that transplanting should be done either early in the morning or late in the evening.\n*Recommended Spacing:*\nSpacing: range from 75cm – 100 cm (between rows) by 40cm – 60 cm (between seedlings) depending on the variety of the tomato.\nPlant Population per Acre: range from 6,666 to 13,333 tomato plants.\n*Fertilizer Application Rates:*\nApply 2 – 3 handfuls of well composted manure per planting hole (8 tons/acre) if not incorporated in soil 2 weeks prior to transplanting.\nApply 2 bottle tops (10 g) of compound fertilizer (NPK) per planting hole (80 kg/acre).",
                        'next_session_step' => 23,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 20,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 23
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 22,
                        'step_title' => "",
                        'next_session_step' => 24,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 20,
                        'reply_type' => 'inline_buttons',
                        'is_next_step_session' => true,
                        'next_session' => 'agrovet',
                        'button_header_type' => 'image',
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/nematodes.png",
                                'response_text' => "*Nematodes*\n\nNematodes are soil borne worms which attack plant roots. They get into vascular bundles of the roots via root tip. They multiply and feed on inside of the roots causing galls hampering water and nutrient uptake resulting in stunted growth, wilting and eventual death of plants. If not controlled, can cause serious loss in yield.\n*SOLUTION*\nDrench BIONEMATON LIQUID (100mls/20L), NIMBECIDINE (100mls/20L).",
                                'next_session_step' => 24,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/early-blight.png",
                                'response_text' => "*Early blight*\n\nThis is a fungal disease which affects foliage, stems and fruits.\nThe fungus is seed borne.\nIt is well adapted to warm wet weather and favoured by warm rainy weather.\n*Symptoms:*\nPremature loss of lower leaves is the main symptom.\nOn leaves, brown circular spots with dark concentric rings appear.\nLeaves turn yellow and dry when only a few spots appear.\nOn fruits, large sunken areas with dark velvet concentric rings appear at the point where the fruit attaches to the stalk.\n*SOLUTION.*\n*Use of fungicides, such as:*\nPREQUEL 72WP 40g/20L (Dimethomorph 120g/Kg + Mancozeb 600g/Kg)\nOSHOTHANE (Mancozeb)\nMISTRESS® (Mancozeb + Cymoxanil) at 40g/20L",
                                'next_session_step' => 24,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/cut-worms.png",
                                'response_text' => "*Cutworms*\n\nThey are capable of eating or destroying the entire plant.\nThey girdle and cut-off young seedlings at ground level during the night, dragging them into the tunnel in the soil and feed on them during the day.\n*SOLUTION*\nUse insecticides, such as:\nDYNAMO 5g/20L\nCYCLOTRON 5mls/20L\nDEGREE MAX 5mls/20L",
                                'next_session_step' => 24,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/tuta-absoluta-transplanting.png",
                                'response_text' => "*Tuta Absoluta*\n\nThis moth is grey-brown, same size and posture as diamond back moth (DBM) and has a long antenna.\nThe Pupa is light brown.\nThe larva (caterpillar) is the damaging stage.\nIt bores on fruits, leaving symptomatic tiny holes.\nIt also burrows on stems causing breakages.\nCan lead to 100% crop loss.\n*SOLUTION.*\nEarly control is important before the pest pressure builds up\nUse PASSWORD 57WDG® 4gms/20L, FIREWORKS 90SC® 10mls/20L, RELAY 150SC® 5mls/20L.\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 24,
                                'next_session' => 'agrovet'
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 25,
                        'step_title' => "Please reply with a number below to know more.\n\n",
                        'next_session_step' => 26,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 8,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Information",
                                'next_session_step' => 26
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Pests & Diseases",
                                'next_session_step' => 27
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 26,
                        'step_title' => "*Water Requirement:*\n\nTomato is sensitive to water deficit immediately after transplanting, during flowering, and fruit stage.\nTomato plants are sensitive to water logging; flooded fields should be drained within 1 – 3 days.\n*Irrigation Methods:*\nFurrow and drip irrigation are the most effective irrigation methods.\nFurrow irrigation minimizes spread of fungal diseases, such as Early Blight.\nDrip irrigation on the other hand is efficient on water utilization.\nOverhead irrigation encourages spread of diseases such as Early Blight.\n*Managing of Weeds:*\nAvoid bruising the roots during weeding. This can be done through use of herbicides and appropriate weeding tools. MOTOPLUS (10g/20L) can be used for weeding\nWeeding Tomato field when the soil is wet can increase the spread of some bacterial (Bacterial Wilt) and fungal (Fusarium Wilt) diseases.\nTomato crop should be fertilized with organic and inorganic chemical fertilizers to produce high yields.\nTop-dressing fertilizer such as CAN should be applied in 2 splits at 40 kg & 80 kg/acre at 4 and 8 weeks after transplanting.",
                        'next_session_step' => 28,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 25,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 28
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 27,
                        'step_title' => "",
                        'next_session_step' => 30,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 25,
                        'reply_type' => 'inline_buttons',
                        'is_next_step_session' => true,
                        'next_session' => 'agrovet',
                        'button_header_type' => 'image',
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/early-blight-vegetative.png",
                                'response_text' => "*Early blight*\n\nThis is a fungal disease which affects foliage, stems and fruits.\nThe fungus is seed borne.\nIt is well adapted to warm wet weather and favoured by warm rainy weather.\n*Symptoms:*\nPremature loss of lower leaves is the main symptom.\nOn leaves, brown circular spots with dark concentric rings appear.\nLeaves turn yellow and dry when only a few spots appear.\nOn fruits, large sunken areas with dark velvet concentric rings appear at the point where the fruit attaches to the stalk.\n*SOLUTION.*\n*Use of fungicides, such as:*\nPREQUEL 72WP 40g/20L (Dimethomorph 120g/Kg + Mancozeb 600g/Kg)\nOSHOTHANE (Mancozeb)\nMISTRESS® (Mancozeb + Cymoxanil) at 40g/20L",
                                'next_session_step' => 30,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/white-flies.png",
                                'response_text' => "*Whiteflies*\n\nThe Adult whitefly resembles a small white moth – like insect which cluster on the underside of upper leaves from which they suck sap.\nThey Suck plant sap and remove nutrients which cause yellowing of infested leaves.\nThe larvae secrete honey dew which supports growth of black sooty mould.\nThey transmit viral diseases, especially Tomato Yellow Leaf Curl Virus. (TYLCV)\n\n*SOLUTION.*\n*Use the following insecticides:*\nCYCLOTRON 5mls/20L\nBETAFOS 20mls/20L\nDEGREE MAX 5mls/20L",
                                'next_session_step' => 30,
                                'next_session' => 'agrovet'

                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/red-spider-mites.png",
                                'response_text' => "*Red Spider Mites*\n\nAdult red spider mites are oval in shape, appear reddish or greenish in colour with eight (8) legs.\nRed spider mites spin silk threads which anchor the pest and their eggs to the plant.\nInfested leaves show white to yellow speckling, which later turn pale or bronzed.\nHigh population causes serious drying and dropping of leaves (defoliation) which leads to smaller and lighter fruits.\n\n*SOLUTION.*\nCLIMB 18EC 10mls/20L\nFIREWORKS 90SC 10mls/20L\nRELAY 15OSC 5mls/20L",
                                'next_session_step' => 30,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/bacteria-wilt.jpg",
                                'response_text' => "*Bacterial wilt*\n\nThis is a bacterial disease which is soil-borne. It is easily spread by runoff water and infested soil.\n*Symptoms:*\nRapid wilting and death of entire plant without yellowing or spotting of leaves.\nWhen the stem of a wilted plant is cut across, the pith has a darkened water-soaked appearance.\nWhen the stem of a wilted plant is squeezed, a greyish slimy ooze is produced.\nTo distinguish this wilt from others when a thin slice is taken from the brown stem tissue and placed inside a glass of water, a milky ooze is produced from the cut surface.\n*SOLUTION.*\nPractice crop rotation with crops such as cereals.\nRemove wilted plants, with the soil around the roots, from the field and destroy.\nDrench ENRICH BM WP® 20gms/20L",
                                'next_session_step' => 30,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/fusarium-wilt.png",
                                'response_text' => "*Fusarium wilt*\n\n• The fungus is both seed- and soil-borne.\nIt causes most damage on light, sandy soils.\nThe fungus can survive in the soil indefinitely even when no tomatoes are grown.\nIt can also survive in fibrous roots of weeds (e.g., Amaranthus, Digitaria and Malva species).\nAcidic soils (pH 5.0 to 5.6) and excessive nitrogen fertilisation promote disease development.\n*Symptoms:*\nThe lower leaves of the plant usually turn yellow and die.\nLeaflets on one side may be affected while those on the other side are symptomless.\nDiseased leaves readily break away from the stem.\nWhen affected stems just above ground level and petioles are cut diagonally, a reddish-brown discolouration of the water conducting tissues will be observed.\n*SOLUTION.*\nUse certified disease-free seeds.\nDo not locate seedbeds on land where Fusarium wilt is known to have occurred.\nWhere soil is acidic, raise the pH by applying lime or farmyard manure.\nAvoid excessive nitrogen fertilisation and control root-knot nematodes.\nDrench PEARL SC® 20mls/20L",
                                'next_session_step' => 30,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/tomato-mosaic-virus.png",
                                'response_text' => "*Tomato Mosaic virus*\n\nThis is a viral disease which is easily transmitted by infected seed and plant debris in the soil.\nIt is mechanically transmitted through transplanting seedlings and pruning tools.\n*Symptoms:*\nMottling of leaves with raised dark green areas.\nThe shape of young leaves is distorted.\nInternal browning of fruits, especially when fruits are affected at mature green stage.\n*SOLUTION.*\nUse certified disease-free seeds.\nRemove crop debris and roots from the field.\nDo not smoke or touch cigarettes as the virus is transmitted.\nUse KALSAN and water mixture of 1:1 ratio to sanitize pruning tools.",
                                'next_session_step' => 30,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/tomato-yellow-leaf-curl.png",
                                'response_text' => "*Tomato Yellow Leaf Curl Virus*\n\n• The disease can be easily recognised when tomato plants are infected at the seedling stage.\nTomato plants infected early in the season are normally stunted and excessively branched.\nAffected leaves are curled upwards or inwards. Flower drop is common, and therefore infected plants have a reduced number of flowers and fruit.\nIf infection takes place at a later stage of growth, fruits already present develop normally. There are no noticeable symptoms on fruits derived from infected plants.\n*SOLUTION.*\n*Control using:*\nCYCLOTRON 5mls/20L\nBETAFOS 20mls/20L\nDEGREE MAX 5mls/20L\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 30,
                                'next_session' => 'agrovet'
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 31,
                        'step_title' => "Please reply with a number below to know more.\n\n",
                        'next_session_step' => 32,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 8,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Information",
                                'next_session_step' => 32
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Pests & Diseases",
                                'next_session_step' => 33
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 32,
                        'step_title' => "*Training and Staking:*\nIndeterminate varieties need staking/training to facilitate pruning, harvesting and other cultural practices.\nDeterminate varieties may be staked in wet season or mulched to prevent fruit contact with the soil to prevent rotting and diseases like blight.\n*Pruning:*\nIt involves removal of side shoots, extra flowers, fruits, and diseased leaves.\nLeads to early maturity of fruits and encourages fruits to increase in size and uniformity.\nSterilize pruning blades by use of KALZAN. Use of unsterilized blades, and smoking can lead to spread of diseases e.g., TMV, Bacterial Wilt.",
                        'next_session_step' => 34,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 31,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 34
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 33,
                        'step_title' => "",
                        'next_session_step' => 35,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 31,
                        'reply_type' => 'inline_buttons',
                        'is_next_step_session' => true,
                        'next_session' => 'agrovet',
                        'button_header_type' => 'image',
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/thrips.png",
                                'response_text' => "*Thrips*\n\nBoth adult and nymphs feed on the lower leaf surface, buds, flowers and fruits.\nIt transmits the Tomato Spotted Wilt Virus/ Tospovirus (“Kijeshi”).\n*Damages:*\nIt attacks leaves causing speckling & small necrotic patches.\nHeavy infestation causes premature wilting, delay in leaf development & distortion of young shoots.\nAttack on buds and flowers leads to abortion.\nThrips are difficult to control with insecticides because their habits partially offer protection from insecticides (eggs are laid in plant tissue, adults shelter in flowers, and larvae pupate in soil)\n*SOLUTION.*\n*Use insecticides such as:*\nUMEME TOP 5EC® 10mls/20L\nFINAL FLIGHT® 5gms/20L",
                                'next_session_step' => 35,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/red-spider-mites-flowering.png",
                                'response_text' => "*Whiteflies*\n\nAdult red spider mites are oval in shape and appear reddish or greenish in colour with eight (8) legs.\nRed spider mites spin silk threads which anchor the pest and their eggs to the plant.\nInfested leaves show white to yellow speckling, and later turn pale or bronzed.\nHigh population causes serious drying and dropping of leaves (defoliation) which leads to smaller and lighter fruits.\n*SOLUTION*\nCLIMB 18EC 10mls/20L\nFIREWORKS 90SC 10mls/20L\nRELAY 15OSC 5mls/20L",
                                'next_session_step' => 35,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/red-spider-mites.png",
                                'response_text' => "*Red Spider Mites*\n\nAdult red spider mites are oval in shape, appear reddish or greenish in colour with eight (8) legs.\nRed spider mites spin silk threads which anchor the pest and their eggs to the plant.\nInfested leaves show white to yellow speckling, which later turn pale or bronzed.\nHigh population causes serious drying and dropping of leaves (defoliation) which leads to smaller and lighter fruits.\n\n*SOLUTION.*\nCLIMB 18EC 10mls/20L\nFIREWORKS 90SC 10mls/20L\nRELAY 15OSC 5mls/20L",
                                'next_session_step' => 35,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/flower-abortion.png",
                                'response_text' => "*Flower Abortion*\n\nMostly caused by extreme temperatures which affect the pollen, causing it to become so sticky that it won’t release into the air.\nWhen the flower fails to pollinate, the plant drops the flowers, pest infestations and fungal diseases may also cause the plant to drop flowers.\nIf your tomato plant is producing lots of fruits, it may drop new flowers in an effort to conserve energy for existing fruits.\nIt may also be a result of imbalance in hormones at this stage especially NAA.\n*SOLUTION.*\nUse PLANTONE at 4mls/20L.",
                                'next_session_step' => 35,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/powdery-mildew.png",
                                'response_text' => "*Powdery Mildew*\n\nPowdery mildews are characterised by spots or patches of white to greyish, talcum-powder-like growth.\nTiny, pinhead-sized, spherical fruiting structures that are first white, later yellow-brown and finally black may be present singly or in a group.\nThe disease is most commonly observed on the upper sides of the leaves. It also affects the lower sides of leaves, young stems, buds, flowers and young fruit.\nInfected leaves may become distorted, turn yellow with small patches of green, and fall prematurely.\nInfected buds may fail to open.\n*Use fungicides, such as:*\nKLASSIC 5EC® 20mls/20L\nTOKEN® 15mls/20L\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 35,
                                'next_session' => 'agrovet'
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 36,
                        'step_title' => "Please reply with a number below to know more.\n\n",
                        'next_session_step' => 37,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 8,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Information",
                                'next_session_step' => 37
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Pests & Diseases",
                                'next_session_step' => 38
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 37,
                        'step_title' => "Tomato takes about 15 days to set fruits and 20-30 days for fruits to mature. During this stage, supplementation of potassium and calcium is critical for overall fruit quality and uniform ripening.",
                        'next_session_step' => 39,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 36,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 39
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 38,
                        'step_title' => "",
                        'next_session_step' => 40,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 36,
                        'reply_type' => 'inline_buttons',
                        'is_next_step_session' => true,
                        'next_session' => 'agrovet',
                        'button_header_type' => 'image',
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/early-blight-fruiting.png",
                                'response_text' => "*Early Blight*\n\nThis is a fungal disease which affects foliage, stems and fruits.\nThe fungus is seed borne.\nIt is well adapted to warm wet weather and favoured by warm rainy weather.\n*Symptoms:*\nPremature loss of lower leaves is the main symptom.\nOn leaves, brown circular spots with dark concentric rings appear.\nLeaves turn yellow and dry when only a few spots appear.\nOn fruits, large sunken areas with dark velvet concentric rings appear at the point where the fruit attaches to the stalk.\n*SOLUTION.*\n*Use fungicides such as:*\nPREQUEL 72WP 40g/20L (Dimethomorph 120g/Kg + Mancozeb 600g/Kg)\nOSHOTHANE (Mancozeb)\nMISTRESS® (Mancozeb + Cymoxanil) at 40g/20L",
                                'next_session_step' => 40,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/blossom-end-rot.png",
                                'response_text' => "*Blossom End Rot*\n\nThis is a physiological condition caused by calcium nitrogen imbalance in the soil, especially when moisture level in the soil is low.\n*Symptoms:*\nA rot at the blossom-end of the fruit.\nThe surface becomes dark brown and sunken.\n*SOLUTION.*\nMaintain adequate soil moisture, especially at fruit development stages.\nSoil liming in calcium deficient soils, reduce N and mulch the field.\nFoliar application of EASY-GRO CALCIUM® 40gms/20L",
                                'next_session_step' => 40,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/late-blight.jpg",
                                'response_text' => "*Late Blight*\n\nThis is a fungal disease which affects foliage and fruits.\nThe development of the disease is favoured by cool and wet conditions.\n*Symptoms:*\nIrregular greenish-black water-soaked patches on leaves.\nThe spots on the leaves later turn brown and the attacked leaves wither but remain attached to the stem.\nWater-soaked brown streaks on stem\nGrey water-soaked spots on fruits – usually the upper half of the fruit with foul smell.\n*SOLUTION.*\nCrop rotation.\nRemoval of all volunteer crops that are more susceptible to this disease.\nPruning and staking to improve air circulation.\nReduce humidity using fungicides:\nPREQUEL 720WP 40g/20L,\nMISTRESS 40g/20L\nMATCO 50g/20L OSHOTHANE 50g/20L",
                                'next_session_step' => 40,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/anthracnose.png",
                                'response_text' => "*Anthracnose*\n\nAnthracnose are diseases of the foliage, stems, or fruits that typically appear as dark-coloured spots or sunken lesions with a slightly raised rim. Some cause twig or branch dieback.\nIn fruit infections, anthracnose often has a prolonged latent stage.\nAnthracnose diseases of fruit often result in fruit drop and fruit rot.\n*SOLUTION*\nMATCO 50gms/20L\nCONTROL DF 10gms/20L",
                                'next_session_step' => 40,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/bacterial-speck.jpg",
                                'response_text' => "*Bacterial Speck*\n\nSmall spots appear on the leaves of the tomato plant.\nThese spots are brown at the centre surrounded by a yellow ring.\nThe spots are small, but in severe cases, they may overlap, which will make them look larger and irregular.\n*SOLUTION.*\nUse ENRICH BM 20gms/20L Water",
                                'next_session_step' => 40,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/bollworm.png",
                                'response_text' => "*Bollworm*\n\nThe female moth lays tiny round & brownish eggs near or on flowers or small fruits.\nCaterpillars feed on flowers and green fruits causing flower abortion and sunken necrotic spots respectively.\nFeeding holes made by the caterpillar serve as entry point for bacteria and fungi which may lead to rotting of fruits.\n*SOLUTION.*\nUMEME TOP 10mls/20L\nDEGREE MAX 2.5mls/20L\nWINNER 2.5mls/20L",
                                'next_session_step' => 40,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/tuta-absoluta-fruiting.png",
                                'response_text' => "*Tuta Absoluta*\n\nThe moth is grey-brown, same size and posture as diamond back moth (DBM) and has a long antenna.\nThe pupa is light brown.\nThe larva (caterpillar) is the damaging stage.\nIt bores on fruits, leaving symptomatic tiny holes.\nIt also burrows on stems causing breakages.\nCan lead to 100% crop loss.\n*SOLUTION.*\nEarly control is important before the pest pressure builds up.\n*Use the following insecticides:*\nPASSWORD 57WDG® 4gms/20L\nFIREWORKS 90SC® 10mls/20L\nRELAY 150SC® 5mls/20L",
                                'next_session_step' => 40,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/red-spider-mites-fruiting.png",
                                'response_text' => "*Red Spider Mites*\n\nAdult red spider mites are oval in shape, appear reddish or greenish in colour with eight (8) legs.\nRed spider mites spin silk threads which anchor the pest and their eggs to the plant.\nInfested leaves show white to yellow speckling, and later turn pale or bronzed.\nHigh population causes serious drying and dropping of leaves (defoliation) which leads to smaller and lighter fruits.\n*SOLUTION.*\nCLIMB 18EC 10mls/20L\nFIREWORKS 90SC 10mls/20L\nRELAY 15OSC 5mls/20L\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 40,
                                'next_session' => 'agrovet'
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 41,
                        'step_title' => "Please reply with a number below to know more.\n\n",
                        'next_session_step' => 42,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 8,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Information",
                                'next_session_step' => 42
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Pests & Diseases",
                                'next_session_step' => 43
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 42,
                        'step_title' => "This takes about 21 to 60 days depending on the variety and the management practices put in place.\n*Stages of fruit ripening:*\n*Breaker -* Red stains appear on fruit skin.\n*Pink -* Tomato turns pink, not yet ready for consumption.\n*Red -* The tomato is red and completely ripe for consumption.",
                        'next_session_step' => 44,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 41,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 44
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 43,
                        'step_title' => "",
                        'next_session_step' => 45,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 41,
                        'reply_type' => 'inline_buttons',
                        'is_next_step_session' => true,
                        'next_session' => 'agrovet',
                        'button_header_type' => 'image',
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/late-blight-harvesting.jpg",
                                'response_text' => "*Late Blight*\n\nThis is a fungal disease which affects foliage and fruits.\nThe development of the disease is favoured by cool and wet conditions.\n*Symptoms:*\nIrregular greenish-black water-soaked patches on leaves.\nThe spots on the leaves later turn brown and the attacked leaves wither but remain attached to the stem.\nWater-soaked brown streaks on stem\nGrey water-soaked spots on fruits – usually the upper half of the fruit with foul smell.\n*SOLUTION.*\nCrop rotation.\nRemoval of all volunteer crops that are more susceptible to this disease.\nPruning and staking to improve air circulation.\nReduce humidity using fungicides:\nPREQUEL 720WP 40g/20L,\nMISTRESS 40g/20L\nMATCO 50g/20L	\nOSHOTHANE 50g/20L",
                                'next_session_step' => 45,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/tuta-absoluta-harvesting.png",
                                'response_text' => "*Tuta Absoluta*\n\nThe moth is grey-brown, same size and posture as diamond back moth (DBM) and has a long antenna.\nThe pupa is light brown.\nThe larva (caterpillar) is the damaging stage.\nIt bores on fruits, leaving symptomatic tiny holes.\nIt also burrows on stems causing breakages.\nCan lead to 100% crop loss.\n*SOLUTION.*\nEarly control is important before the pest pressure builds up.\n*Use the following insecticides:*\nPASSWORD 57WDG® 4gms/20L\nFIREWORKS 90SC® 10mls/20L\nRELAY 150SC® 5mls/20L",
                                'next_session_step' => 45,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/bollworm-harvesting.png",
                                'response_text' => "*Bollworm*\n\nThe female moth lays tiny round & brownish eggs near or on flowers or small fruits.\nCaterpillars feed on flowers and green fruits causing flower abortion and sunken necrotic spots respectively.\nFeeding holes made by the caterpillar serve as entry point for bacteria and fungi which may lead to rotting of fruits.\n*SOLUTION.*\nUMEME TOP 10mls/20L\nDEGREE MAX 2.5mls/20L\nWINNER 2.5mls/20L",
                                'next_session_step' => 45,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/bacterial-speck-harvesting.jpg",
                                'response_text' => "*Bacterial Speck*\n\nAnthracnose are diseases of the foliage, stems, or fruits that typically appear as dark-coloured spots or sunken lesions with a slightly raised rim. Some cause twig or branch dieback.\nIn fruit infections, anthracnose often has a prolonged latent stage.\nSmall spots appear on the leaves of the tomato plant.\nThese spots are brown at the centre surrounded by a yellow ring.\nThe spots are small, but in severe cases, they may overlap, which will make them look larger and irregular.\n*SOLUTION.*\nUse ENRICH BM 20gms/20L Water",
                                'next_session_step' => 45,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/anthracanose-harvesting.png",
                                'response_text' => "*Anthracnose*\n\nAnthracnose are diseases of the foliage, stems, or fruits that typically appear as dark-coloured spots or sunken lesions with a slightly raised rim. Some cause twig or branch dieback.\nIn fruit infections, anthracnose often has a prolonged latent stage.\nAnthracnose diseases of fruit often result in fruit drop and fruit rot.\n*SOLUTION.*\nMATCO 50gms/20L\nCONTROL DF 10gms/20L",
                                'next_session_step' => 45,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/bollworm.png",
                                'response_text' => "*Bollworm*\n\nThe female moth lays tiny round & brownish eggs near or on flowers or small fruits.\nCaterpillars feed on flowers and green fruits causing flower abortion and sunken necrotic spots respectively.\nFeeding holes made by the caterpillar serve as entry point for bacteria and fungi which may lead to rotting of fruits.\n*SOLUTION.*\nUMEME TOP 10mls/20L\nDEGREE MAX 2.5mls/20L\nWINNER 2.5mls/20L",
                                'next_session_step' => 45,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/tuta-absoluta-fruiting.png",
                                'response_text' => "*Tuta Absoluta*\n\nThe moth is grey-brown, same size and posture as diamond back moth (DBM) and has a long antenna.\nThe pupa is light brown.\nThe larva (caterpillar) is the damaging stage.\nIt bores on fruits, leaving symptomatic tiny holes.\nIt also burrows on stems causing breakages.\nCan lead to 100% crop loss.\n*SOLUTION.*\nEarly control is important before the pest pressure builds up.\n*Use the following insecticides:*\nPASSWORD 57WDG® 4gms/20L\nFIREWORKS 90SC® 10mls/20L\nRELAY 150SC® 5mls/20L",
                                'next_session_step' => 45,
                                'next_session' => 'agrovet'
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'image_url' => "https://api1.sasa.ai/images/red-spider-mites-fruiting.png",
                                'response_text' => "*Red Spider Mites*\n\nAdult red spider mites are oval in shape, appear reddish or greenish in colour with eight (8) legs.\nRed spider mites spin silk threads which anchor the pest and their eggs to the plant.\nInfested leaves show white to yellow speckling, and later turn pale or bronzed.\nHigh population causes serious drying and dropping of leaves (defoliation) which leads to smaller and lighter fruits.\n*SOLUTION.*\nCLIMB 18EC 10mls/20L\nFIREWORKS 90SC 10mls/20L\nRELAY 15OSC 5mls/20L\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 45,
                                'next_session' => 'agrovet'
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 4,
                        'step_title' => "Are you satisfied with the response\nyou have received? Please\nreply with an option below.👇🏾\n\n",
                        'next_session_step' => 5,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 3,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => 'Yes',
                                'next_session_step' => 5
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => 'No',
                                'next_session_step' => 6
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 5,
                        'step_title' => "Thank you for being our valued\ncustomer.🙂👍🏽\n\nReply with *99* to exit.",
                        'next_session_step' => 6,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => '',
                                'next_session_step' => 6
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 6,
                        'step_title' => "To speak to an agent, please\nsend us a direct email on\ncustomercare@oshochem.com\nor call us on\n(+254) 0711 045000 or send us\na message on 20560.\n\nReply with *99* to exit.",
                        'next_session_step' => 7,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "",
                                'next_session_step' => 7
                            ]

                        ]
                    ]
                ]
            ],
            [
                'session_name' => 'animal_health',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 3,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Dairy cow\n\nType *99* to go back home",
                                'next_session_step' => 1
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 44,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => 'Veterinary Professional',
                                'next_session_step' => 44
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => 'Farmer',
                                'next_session_step' => 49
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 0,
                                'response_text' => "\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 20
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 44,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 45,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 1,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Diseases/Pests/Conditions\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 45
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 45,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 3,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 44,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => 'East Coast Fever',
                                'next_session_step' => 2
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => 'Anaplasmosis',
                                'next_session_step' => 10
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => 'General Bacteria Infection',
                                'next_session_step' => 20
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'show_step_id' => 1,
                                'response_text' => 'Vitamin Deficiency',
                                'next_session_step' => 21
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'show_step_id' => 1,
                                'response_text' => 'Mineral Supplement',
                                'next_session_step' => 22
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'show_step_id' => 1,
                                'response_text' => 'Hypomagnesemia & Constipation',
                                'next_session_step' => 23
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 7,
                                'show_step_id' => 1,
                                'response_text' => 'Animal Feed additives',
                                'next_session_step' => 24
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 8,
                                'show_step_id' => 1,
                                'response_text' => 'Feed supplements',
                                'next_session_step' => 30
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 9,
                                'show_step_id' => 1,
                                'response_text' => 'Liver functionality',
                                'next_session_step' => 38
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 10,
                                'show_step_id' => 1,
                                'response_text' => 'Injectable supplement',
                                'next_session_step' => 39
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 11,
                                'show_step_id' => 1,
                                'response_text' => "Calf milk replacer\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 40
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 2,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 3,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "ECF Control",
                                'next_session_step' => 3
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "ECF Treatment",
                                'next_session_step' => 8
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => "Learn more About East Coast Fever\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 9
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 3,
                        'step_title' => "Please type in the number to select\nan acaricide product below.👇🏾\n\n",
                        'next_session_step' => 4,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 2,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => 'Actraz',
                                'next_session_step' => 4
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => 'Tickstop',
                                'next_session_step' => 5
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => 'Ex-Kupe',
                                'next_session_step' => 6
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'show_step_id' => 1,
                                'response_text' => 'Eliminator',
                                'next_session_step' => 7
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 4
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 4,
                        'step_title' => "*Actraz*\nActraz is an acaricide for control of Tick,\nfleas, Lice and Mange mites in Cattle.\n*Active molecule:* Amitraz 12.5% EC\n*Application Rates:* Use 40mls of Actraz\nin 20Litres of Water\n*Frequency:* Every 7days\n*Withdrawal period:* Meat - 4days,\nMilk - 7hours.",
                        'next_session_step' => 4,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 3,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 5,
                        'step_title' => "*Tickstop*\nTickstop is an Ectoparasiticide with a combination of\nOrganophosphorus and Synthetic Pyrethroids working\nin synergy for control of Ticks, Fleas, Mites, Biting\ninsects and Lice in Cattle\n*Active Molecule:* Chlorpyriphos 500g/l + Cypermethrin 50g/l\n*Application Rates:* Mix 1 ml of Tickstop to 1 litre of water\n*Frequency:* Every 7days\n*Withdrawal Period:*  Meat - 24 hrs, Milk - 10 hours.",
                        'next_session_step' => 6,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 3,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 6,
                        'step_title' => "*Ex-Kupe*\nEx- Kupe is an acaricide and insecticide for\ncontrol of Ticks and other biting insects\n(Fleas, lice, tsetse fly, Mites, lice & biting\ninsects) on Livestock.\n*Active Molecule:* Deltamethrin 50g/L\n*Application rates:* Mix 10ml of EX-Kupe to\n10litres of water\n*Frequency:* Every 7days\n*Withdrawal period:* Meat – 24hours,\nMilk - 6hours.",
                        'next_session_step' => 7,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 3,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 7,
                        'step_title' => "*Eliminator*\nEliminator contains synthetic pyrethroids which\nis very effective to control of ticks, fleas, tsetse\nflies, and biting flies on cattle.\n*Active molecule:* Alphacypermethrin 10%\n*Application rates:* Mix 10mls of Eliminator to\n20 litres of water.\n*Application Frequency:* repeat every 7 days.\n*Withdrawal period:* Meat - 24hours,\nMilk - 6hours.",
                        'next_session_step' => 8,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 3,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 8,
                        'step_title' => "*Butawock Products*\nButawock contains Buparvaquone for Treatment and prophylaxis of all forms of theileriosis and can be Used during incubation period or when clinical signs appear.\n*Dosage:* 2.5mg/kg or 1ml per 20kg body weight via Deep intra -muscular route at the neck muscles. Do not inject more than 10mls at one site. A repeat dose should be given at an interval of 48 -72 hours.\n*Withdrawal period:* Meat – 42days, Milk – 48hours",
                        'next_session_step' => 9,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 2,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 9,
                        'step_title' => "East coast fever is a Lethal Tick-borne disease mainly in cattle in tropical areas. The disease is transmitted by infected Ticks from one infected animal to another uninfected animal.\nThe most common clinical signs in Acute observed include:\n-Fever 40 Degrees Celsius.\n- Anorexia (sudden Poor appetite)\n- Difficulty in breathing and coughing\n- Pulmonary Oedema\n- Excess mucus discharge\n- Hemorrhagic petechiation under the tongue\n- Swollen prescapular Lymph node\n- Corneal opacity\n- Sometimes Death*Best control measure:* Spray The animal every 7 days with Acaricides\nUse the different available molecules interchangeably to reduce effects of resistance\nUse Actraz 40mls/20litre or Tickstop 20ml /20 litres for each animal or Eliminator 20ml/20 litres or Exkupe 10ml/20litre.",
                        'next_session_step' => 10,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 2,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 10,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 3,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Anaplasmosis Control",
                                'next_session_step' => 11
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Anaplasmosis Treatment",
                                'next_session_step' => 16
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => "Learn more About Anaplasmosis\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 17
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 11,
                        'step_title' => "Please type in the number to select\nan acaricide product below.👇🏾\n\n",
                        'next_session_step' => 12,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 10,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => 'Actraz',
                                'next_session_step' => 12
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => 'Tickstop',
                                'next_session_step' => 13
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => 'Ex-Kupe',
                                'next_session_step' => 14
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'show_step_id' => 1,
                                'response_text' => "Eliminator\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 15
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 12,
                        'step_title' => "*Actraz*\n*Actraz:* This is an acaricide for control of Tick, fleas, Lice and Mange mites in Cattle\n*Active molecule:* Amitraz 12.5% EC\n*Application Rates:* Use 40mls Actraz in 20Litres of Water\n*Frequency:* Every 7days\n*Withdrawal period:* Meat - 4days, Milk - 7hours",
                        'next_session_step' => 13,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 11,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 13,
                        'step_title' => "*Tickstop*\nTickstop is an Ectoparasiticide with a combination of Organophosphorus and Synthetic Pyrethroids working in synergy for control of Ticks, Fleas, Mites, Biting insects and Lice in Cattle.\n*Active Molecule:* Chlorpyriphos 500g/l + Cypermethrin 50g/l\n*Application Rates:* Mix 1 ml of Tickstop to 1 litre of water\n*Frequency:* Every 7days\n*Withdrawal Period:*  Meat - 24 hrs, Milk - 10 hours",
                        'next_session_step' => 14,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 11,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 14,
                        'step_title' => "*Ex-Kupe*\nEx- Kupe is an acaricide and insecticide for control of Ticks and other biting insects (Fleas, lice, tsetse fly, Mites, lice & biting insects) on Livestock.\n*Active Molecule:* Deltamethrin 50g/L\n*Application rates:* Mix 10ml of EX-Kupe to 10litres of water\n*Frequency:* Every 7days\n*Withdrawal period:* Meat – 24hours, Milk - 6hours",
                        'next_session_step' => 15,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 11,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 15,
                        'step_title' => "*Eliminator*\nEliminator contains synthetic pyrethroids which is very effective to control of ticks, fleas, tsetse flies, and biting flies on cattle.\n*Active molecule:* Alphacypermethrin 10%\n*Application rates:* Mix 10mls of Eliminator to 20 litres of water.\n*Application Frequency:* repeat every 7 days.\n*Withdrawal period:* Meat – 24hours, Milk - 6hours",
                        'next_session_step' => 16,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 11,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 16,
                        'step_title' => "*Vetocycline*\nVetocycline contains Oxytetracycline which broad spectrum antibiotic with a bacteriostatic activity against both Gram negative & Gram-positive bacteria and rickettsia species in cattle.\n*Dosage:* 1ml/10kg bodyweight for 3-5 days via intramuscular route\n*Withdrawal period:* Meat – 14 days, Milk – 3 days (72hours)",
                        'next_session_step' => 17,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 10,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 17,
                        'step_title' => "Anaplasmosis is a protozoan tick-borne disease of cattle and sheep. The main causative agent is Anaplasma species. The parasite is found in red blood cells causing Destruction.\nThe major clinical signs include:\n• Anemia- Pale Mucus membranes\n• Anorexia – low appetite in the affected animal\n• Reduced Milk production\n• Constipation due to Rumen atony\n• Rapid weight loss, and yellow tinged skin.\n• The animal may be unable to rise.\n• Affected cattle either die or begin a recovery 1 to 4 days after the first signs\n*Control*\nUse Actraz 40mls/20litre or Tickstop 20ml /20 litres for each animal or Eliminator 20ml/20 litres or Ex-Kupe 10ml/20litre.",
                        'next_session_step' => 18,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 10,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 20,
                        'step_title' => "*Meriquin*\nMeriquin is a broad-spectrum bactericidal antibiotic containing Enrofloxacin 10% that works against mainly Gastrointestinal and respiratory infections caused by enrofloxacin sensitive micro-organisms, like Campylobacter, Actinobaccilosis, E. coli, Hemophilus, Mycoplasma, Pasteurella and Salmonella spp. in calves, cattle, sheep, goats and swine. \n*Dosage:* 1ml per 20 -40kg Body weight for 3-5 days\n*Route of administration:* Subcutaneously /intramuscularly\n*Withdrawal period:* Meat – 21 days, Milk - 4 days",
                        'next_session_step' => 21,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 21,
                        'step_title' => "*BEEKOM – L*\nIt’s a Vitamins B complex Injection with crude liver extracts for maintaining liver function in anorexic, stressed, and recovering animals.\n*Indications:* used in Animals recovering from Protozoan infection, Heavy liver fluke infestation, Fatty liver syndrome, General weakness, emaciation, Jaundice, and chronic infections.\n*Dosage rates:* Cattle- 5- 10mls every 48hours by deep intramuscular route.\n*Withdrawal period:* 0 days for meat and milk.",
                        'next_session_step' => 22,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 22,
                        'step_title' => "*Cattlemin Maziwa*\nA specially formulated mineral supplement with Macro minerals and trace elements for Lactating and growing animals. \n*Dosage rates:* \n• Lactating/In-calf’s cows – 100grams per cow daily (4 heaped tablespoons)\n• Heifers – 75grams daily (3 heaped tablespoon)\n• Calves – 50 grams daily (2 heaped tablespoon)\n*Cattle lamba white*\nA special block for use in Dairy animals (Lactating and In-calf)\n*Dosage rates:* Free access.",
                        'next_session_step' => 23,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 23,
                        'step_title' => "*Animatic Epsom salt*\nIt contains Magnesium sulphate 99.5% for use as treatment of constipation and correcting clinical magnesium deficiency in cattle, sheep and Goats. \n*Dosage:* \n• As a Saline purgative for treating constipation (given with water as a drench): Cattle 250 – 500 grams per animal \n• Hypomagnesaemia (Grass Tetany) treatment. Given by subcutaneous injection (10% solution with sterile water): Calves 100 ml, Cattle 150 – 200 ml",
                        'next_session_step' => 24,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 24,
                        'step_title' => "Type in a number to choose an option below.👇🏾\n",
                        'next_session_step' => 25,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Mycotoxin Binders",
                                'next_session_step' => 25
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Calcium phosphorus supplement",
                                'next_session_step' => 26
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => "Probiotics\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 27
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 25,
                        'step_title' => "*Toxorid BIO*\nA broad spectrum herbal based toxin binder for Mycotoxins, Bacterial toxins, Aflatoxins, herbicides, fungicides, and pesticides residues in animal feeds. \n*Dosage And Administration:*\nFeed with Moisture\n< 15% - 1 kg/tonne \n> 15% - 2 kg/tonne",
                        'next_session_step' => 26,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 24,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 26,
                        'step_title' => "*Animatic DCP*\nA dietary supplement used in the treatment and control of calcium/phosphorous related deficiencies in all livestock.\n*Dosage:* \n500 grams per 70 kg of feed.",
                        'next_session_step' => 27,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 24,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 27,
                        'step_title' => "*Biovet YC Gold*\nA Biologically derived natural product which inherently contains Probiotics & amino acids. It helps to improve feed digestion, milk production and rumen immunity. \n*Directions for use:* \n• Use 20g of Biovet-YC Gold per Cow\n• Soak in water overnight\n• Do Top Dressing in the morning.\n• Mix thoroughly with feed\n*Dosage and Administration:* By Oral route. \n• Large animals: Individual feeding 15-20g daily\n• Feeds: 1- 2kg/tonne",
                        'next_session_step' => 28,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 24,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 30,
                        'step_title' => "Type in a number to choose an option below.👇🏾\n",
                        'next_session_step' => 31,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Animatic Batista",
                                'next_session_step' => 31
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Liquid Calcium",
                                'next_session_step' => 32
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => "Happy Farm\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 33
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 31,
                        'step_title' => "*Animatic Batista*\nA rumenotoric and digestive stimulant containing vitamins, trace minerals and probiotic to promote appetite, strengthen rumen immunity and enhance proper functioning of the digestive tract.\n*Dosage rate:* 50 grams per day for 2 days (1st and 3rd day)",
                        'next_session_step' => 32,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 30,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 32,
                        'step_title' => "*Liquid Calcium*\nLiquid calcium feed supplement containing calcium & phosphorous. It also contains a unique combination of magnesium, vitamins D3, B12 and Biotin. \nIt is indicated for use in: \n• Treatment of hypocalcemia around calving\n• Improving of milk synthesis, yield, and fat content\n• Improvement of appetite and bone development in growing animals\n• Mineral and Vitamins supplementation Improving appetite.\n• Helps to prevent grass tetany.\n*Dosage Administer:* via Oral route. Cattle 100ml daily.",
                        'next_session_step' => 33,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 30,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 33,
                        'step_title' => "*Happy Farm*\nA feed ingredient expertly formulated by adding organic minerals, vitamins, amino acids, carbohydrates, and digestive enhancers designed to provide nutritionally balanced feeds for cattle, poultry, and pig.\nBenefits:\n• Regulates the stomach microflora of animals.\n• Improves dry matter intake and digestibility of animals on the transitional period or when use the anomalous feed or feed additive for feeding\n• Help to boost milk production and increase milk fat and protein contents.\n*Feeding direction:*\n• Calves- 1 Teaspoon daily\n• Adult Cows/Bulls 1 Tablespoon daily",
                        'next_session_step' => 34,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 30,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 38,
                        'step_title' => "*Livotox*\nIt contains herbal extract for liver protection against various hepatotoxins, Drug toxicity and Metabolic disorders\n*Indications:* \n• Fatty Liver Syndrome  \n• Liver Enlargement \n• Cholecystitis and Cholangitis \n• Hepatitis \n• Liver Cirrhosis and Fibrosis\n• Drug Induced hepatotoxicity\n*Dosage:*\nDairy Cattle : 20 - 40 ml in drinking water",
                        'next_session_step' => 39,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 39,
                        'step_title' => "*Tonoricin*\nInjectable phosphorus (4-dimethylamino-2-methylphenyl-phosphinic acid). Tonoricin contains Organic Phosphorus very important in energy metabolism, replenishing serum phosphorus levels, supporting liver function and stimulating fatigued smooth and cardiac muscle.\n*Indications:* \n• Treating Metabolic disorder like ketosis in cattle, poor feeding disease stress or over exhaustion.\n•  Treating Reproductive problems like Metritis, infertility, delayed heat or lack of visible heat signs. \n• Treatment of Muscular disorders E.g., in Milk fever, Downer cow syndrome, Vaginal prolapse, post-partum hemoglobinuria\n*Dosage:* Cattle 10-25ml by Intravenous, subcutaneously & intramuscularly route",
                        'next_session_step' => 40,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 40,
                        'step_title' => "*Animatic super Ndama*\nIt’s a specially formulated diet for feeding calves from Day 4 after birth with 70% milk products, Vitamins and minerals for optimum growth and better calf immunity.\n*Dosage and feeding recommendation:*\n• Add 1 to 1.25kg of animatic milk replacer to 10litres of warm water (100-125g/liter)",
                        'next_session_step' => 40,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 45,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 0
                            ]
                        ]
                    ],
                    //farmer user journey
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 49,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 50,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 1,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Diseases/Pests/Conditions\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 50
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 50,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 51,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 49,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => 'Mastitis',
                                'next_session_step' => 51
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => 'Internal Parasites',
                                'next_session_step' => 56
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => 'External Parasites',
                                'next_session_step' => 65
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'show_step_id' => 1,
                                'response_text' => 'Mineral supplement',
                                'next_session_step' => 75
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'show_step_id' => 1,
                                'response_text' => 'Hypomagnesemia & Constipation',
                                'next_session_step' => 95
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'show_step_id' => 1,
                                'response_text' => 'Animal Feed additives',
                                'next_session_step' => 78
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 7,
                                'show_step_id' => 1,
                                'response_text' => 'Feed supplements',
                                'next_session_step' => 85
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 8,
                                'show_step_id' => 1,
                                'response_text' => 'Liver functionality',
                                'next_session_step' => 90
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 9,
                                'show_step_id' => 1,
                                'response_text' => "Calf milk replacer\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 91
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 51,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 52,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 50,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Mastitis prevention",
                                'next_session_step' => 52
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Mastitis Treatment",
                                'next_session_step' => 53
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => "Learn about Mastitis/What is mastitis?",
                                'next_session_step' => 54
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 54
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 52,
                        'step_title' => "*Before milking*\n",
                        'next_session_step' => 53,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 51,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "*Mastikinga Step 1:*\nMastikinga step 1 is a Pre-Milking Dipping Solution containing 8.0% w/w lactic acid used before milking for cleaning, sanitizing and softening the teats before milking.\n*Usage instructions:* \nMix in foam cup 40% of the Mastikinga step 1 with water \n*Milking Salve*\nMilking salve is a creamy white to off white ointment containing lanolin and cetrimide which makes the milking process hygienic and smooth by preventing the occurrence of sores and dry cracks on the teat and udder during milking.\n*Application Instructions:*\n• Clean the udder and Teats with clean warm water\n• Dip the teats in Mastikinga Step 1, and rinse and wipe off excess water with a clean towel.\n• Apply Animatic milking salve on milkers’ hand, then apply on the teats.\n*After Milking*\n*Mastikinga step 2:*\nMastikinga step 2 is a Post-Milking Dipping Solution containing 0.5 % w/w chlorhexidine Di gluconate used after milking. It’s a ready to use and is suitable for dipping the teats immediately after each milking.",
                                'next_session_step' => 53
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 53
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 53,
                        'step_title' => "Mastiwock is an intramammary infusion containing Cefoperazone, it’s indicated for use in treating sub -Clinical and Clinical mastitis in lactating animals as Single dose treatment.\nDirections for use:\n• Milk out the udder before treatment\n• Observe Hygiene\n• Wipe with antiseptic wipe of isopropanol solution 70% \n• Inject 10ml pre-filed syringe into the affected Quarter\nWithdrawal period: Milk - 84 hours",
                        'next_session_step' => 54,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 51,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 54
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 54,
                        'step_title' => "Mastitis is the inflammation of mammary gland and udder tissue. This is mainly caused by Bacteria contamination from the environment due to unhygienic milking practices or udder Trauma.\n*Mastitis occurs in 2 main Forms.*\nSubclinical form – mainly has no clinical signs, only detected by Milk test for high somatic count\nClinical form – most identified form, characterized by Fever, drop in milk production, Inflammation of udder, Hot udder, milk maybe watery/with blood/flakes/ change in color.\n*Control:*\n• Use one clean drying towel for each cow.\n• Clean the udder properly before milking\n• The milker should Clean hands with soap and water before milking\n• Use Animatic milking salve, to soften the teats to avoid injury and act as antiseptic\n• After Milking, apply Animatic salve and dip the teat into Mastikinga solution to block entry of bacteria",
                        'next_session_step' => 55,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 51,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 55
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 56,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 57,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 50,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "All Worms",
                                'next_session_step' => 57
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Liver flukes",
                                'next_session_step' => 60
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => "Learn about internal parasites in cows",
                                'next_session_step' => 63
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 57
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 57,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 58,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 56,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Endoguard",
                                'next_session_step' => 58
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Parakill",
                                'next_session_step' => 59
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 58
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 58,
                        'step_title' => "*Composition:* Albendazole 100mg/ml + Selenium +cobalt+ zinc + Copper.\n*Description:* Endoguard is a broad-spectrum oral drench dewormer effective against Roundworms (stomach & intestinal worms), Lungworms, Tapeworms and Liver flukes in Cattle.\n*Dosage:* Based on animal weight as indicated on the label.",
                        'next_session_step' => 59,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 57,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 58
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 59,
                        'step_title' => "*Composition:* Levamisole 1.5% & Oxyclozanide 3.0% with Cobalt + Selenium\n*Description:* Parakill is broad spectrum oral drench with a combination of Levamisole & Oxyclozanide working in synergy to kill round worms (stomach & Intestinal worms) Lungworms and All stages of Liver flukes in Cattle\n*Dosage:* Based on animal weight as indicated on the label.",
                        'next_session_step' => 60,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 57,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 60
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 60,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 61,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 56,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Endoguard",
                                'next_session_step' => 61
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Parakill",
                                'next_session_step' => 62
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 61
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 61,
                        'step_title' => "*Composition:* Albendazole 100mg/ml + Selenium +cobalt+ zinc + Copper.\n*Description:* Endoguard is a broad-spectrum oral drench dewormer effective against Roundworms (stomach & intestinal worms), Lungworms, Tapeworms and Liver flukes in Cattle.\n*Dosage:* Based on animal weight as indicated on the label.",
                        'next_session_step' => 62,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 60,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 62
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 62,
                        'step_title' => "*Composition:* Levamisole 1.5% & Oxyclozanide 3.0% with Cobalt + Selenium\n*Description:* Parakill is broad spectrum oral drench with a combination of Levamisole & Oxyclozanide working in synergy to kill round worms (stomach & Intestinal worms) Lungworms and All stages of Liver flukes in Cattle\n*Dosage:* Based on animal weight as indicated on the label.",
                        'next_session_step' => 63,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 60,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 63
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 63,
                        'step_title' => "Worms are internal parasites of animals. They are mainly found in Stomach, Intestines, lungs, and Liver of cows. There are many types of worms that cause negative effects in animals.\nMain signs of worms in your animals\n• Loss of appetite\n• Frequent diarrhea\n• Visible worms’ segment in Fecal material\n• Slow growth rate in young animals\n• Rough Haircoat\n• In case of lungworms infestation; Coughing and excess nasal Discharge.\n• Swelling on lower abdomen that is fluid filled \n*Best control for worms*\n• Use dewormers with different molecules every time you deworm Albendazoles (Endoguard) or combination dewormers (Parakill)\n• Dewomers that are fortified with Cobalt and selenium help improve recovery rates in animals",
                        'next_session_step' => 63,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 56,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 63
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 65,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 66,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 50,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "External Parasite Control",
                                'next_session_step' => 66
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Learn about external parasites",
                                'next_session_step' => 71
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 54
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 66,
                        'step_title' => "Please type in the number to select\nan acaricide product below.👇🏾\n\n",
                        'next_session_step' => 67,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 65,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => 'Actraz',
                                'next_session_step' => 67
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => 'Tickstop',
                                'next_session_step' => 68
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => 'Ex-Kupe',
                                'next_session_step' => 69
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'show_step_id' => 1,
                                'response_text' => 'Eliminator',
                                'next_session_step' => 70
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 70
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 67,
                        'step_title' => "Actraz is an acaricide for control of Tick, fleas, Lice and Mange mites in Cattle, Sheep and Goats.\n*Active molecule:* Amitraz 12.5% EC\n*Application Rates:* Use 40mls /20Litres of Water\n*Frequency:* Every 7days\n*Withdrawal period:* Meat - 4days, Milk - 7hours",
                        'next_session_step' => 68,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 66,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 68
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 68,
                        'step_title' => "Tickstop is an Ectoparasiticide with a combination of Organophosphorus and Synthetic Pyrethroids working in synergy for control of Ticks, Fleas, Mites, Biting insects and Lice in Cattle, Sheep and Goats.\n*Active Molecule:* Chlorpyriphos 500g/l + Cypermethrin 50g/l\n*Application Rates:* Mix 1 ml of Tickstop to 1 litre of water \n*Frequency:* Every 7days\n*Withdrawal Period:* Meat - 24 hrs, Milk - 10 hours",
                        'next_session_step' => 69,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 66,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 69
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 69,
                        'step_title' => "Ex- Kupe is an acaricide and insecticide for control of Ticks and other biting insects (Fleas, lice, tsetse fly, Mites, lice & biting insects) on Livestock.\n*Active Molecule:* Deltamethrin 50g/L\n*Application rates:* Mix 10ml of EX-Kupe to 10litres of water\n*Frequency:* Every 7days\n*Withdrawal period:* Meat – 24hours, Milk - 6hours",
                        'next_session_step' => 69,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 66,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 69
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 70,
                        'step_title' => "Eliminator contains synthetic pyrethroids which is very effective to control of ticks, fleas, tsetse flies, and biting flies on cattle, chicken, sheep, goats, camels, pigs, cats, and dogs.\n*Active molecule:* Alphacypermethrin 10%\n*Application rates:* Mix 10mls of Eliminator to 20 liters of water.\n*Application Frequency:* repeat every 7 days.\n*Withdrawal period:* Meat – 24hours, Milk - 6hours",
                        'next_session_step' => 71,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 66,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 71
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 71,
                        'step_title' => "External parasites are mainly found on the animal skin. They cause damage to the skin and depressed the animal health as below:\n• Ticks – sucks blood and transmits diseases like East coast fever and Anaplasmosis.\n• Fleas and lice – Suck’s blood, causes animal scratching and leads to loss of hair.\n• Mites – they burrow into the skin of the animal, causing scratching, loss of hair and formation of dry cracks and wounds.\nAll these parasites can be controlled by different acaricides including Use Actraz 40mls/20litre or Tickstop 20ml /20 liters or Eliminator 20ml/20 litres or Ex-Kupe 10ml/20litre.",
                        'next_session_step' => 72,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 65,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 72
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 75,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 76,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 50,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Cattlemin Maziwa",
                                'next_session_step' => 76
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Cattle lamba white",
                                'next_session_step' => 77
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 77
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 76,
                        'step_title' => "A specially formulated mineral supplement with Macro minerals and trace elements for Lactating and growing animals.\n*Dosage rates:* \n• Lactating/In-calf’s cows – 100grams per cow daily (4 heaped tablespoons)\n• Heifers – 75grams daily (3 heaped tablespoon)\n• Calves – 50 grams daily (2 heaped tablespoon)",
                        'next_session_step' => 77,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 75,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 77
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 77,
                        'step_title' => "A special block for use in Dairy animals (Lactating and In-calf).\n*Dosage rates:* Free access.",
                        'next_session_step' => 77,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 75,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 77
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 95,
                        'step_title' => "*Animatic Epsom salt*\nIt contains Magnesium sulphate 99.5% for use as treatment of constipation and correcting clinical magnesium deficiency in cattle.\n*Dosage:*\n• Administered as a Saline purgative for treating constipation (given with water as a drench): Cattle 250 – 500 grams per animal",
                        'next_session_step' => 78,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 50,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 78
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 78,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 79,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 50,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Mycotoxin Binders",
                                'next_session_step' => 79
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Calcium phosphorus supplement",
                                'next_session_step' => 80
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 54
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 79,
                        'step_title' => "*Toxorid BIO*\nA broad spectrum herbal based toxin binder for Mycotoxins, Bacterial toxins, Aflatoxins, herbicides, Fungicides and pesticides residues in animal feeds.*Dosage And Administration:* Feed with Moisture < 15% - 1 kg/tonne > 15% - 2 kg/tonne.",
                        'next_session_step' => 80,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 78,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 80
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 80,
                        'step_title' => "*Animatic DCP*\nA dietary supplement used in the treatment and control of calcium/phosphorous related deficiencies in all livestock\n*Dosage:* 500 grams per 70 kg of feed. A biologically derived natural product which inherently contains Probiotics & amino acids. It helps to improve feed digestion, milk production and rumen immunity.\n*Directions for use:*\n• Use 20g of Biovet-YC Gold per Cow\n• Soak in water overnight\n• Do Top Dressing in the morning.\n• Mix thoroughly with feed\n*Dosage and Administration:* By Oral route.\n• Large animals: Individual feeding 15-20g daily\n•  Feeds: 1- 2kg/tonne ",
                        'next_session_step' => 81,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 78,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 81
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 85,
                        'step_title' => "Please type in the number to select\nan option below.👇🏾\n\n",
                        'next_session_step' => 86,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 50,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => "Animatic Batista",
                                'next_session_step' => 86
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => "Liquid Calcium",
                                'next_session_step' => 87
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 1,
                                'response_text' => "Happy Farm",
                                'next_session_step' => 88
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 89
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 86,
                        'step_title' => "A rumenotoric and digestive stimulant containing vitamins, trace minerals and probiotic to promote appetite, strengthen rumin immunity and enhance proper functioning of the digestive tract.\n*Dosage rate:* 50 grams per day for 2 days (1st and 3rd day)",
                        'next_session_step' => 87,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 85,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 87
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 87,
                        'step_title' => "Liquid calcium feed supplement containing calcium & phosphorous. It also contains a unique combination of magnesium, vitamins D3, B12 and Biotin.it is indicated for use in:\n• Treatment of hypocalcemia around calving\n• Improving of milk synthesis, yield and fat content\n• Improvement of appetite and bone development in growing animals\n• Mineral and Vitamins supplementation Improving appetite\n• Helps to prevent grass tetany.\nDosage Administer: via Oral route. Cattle 100ml daily.",
                        'next_session_step' => 88,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 85,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 88
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 88,
                        'step_title' => "A feed ingredient expertly formulated by adding organic minerals, vitamins, amino acids, carbohydrates and digestive enhancers designed to provide nutritionally balanced feeds for cattle, poultry and pig.\n*Benefits:*\n• Regulates the stomach microflora of animals.\n• Improves dry matter intake and digestibility of animals on the transitional period or when use the anomalous feed or feed additive for feeding\n*Feeding direction:*\n• Calves- 1 Teaspoon daily\n• Adult Cows/Bulls 1 Tablespoon daily",
                        'next_session_step' => 88,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 85,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 88
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 90,
                        'step_title' => "*Livotox -* It contains herbal extract for liver protection against various hepatotoxins, Drug toxicity and Metabolic disorders\n*Indications:*\n• Fatty Liver Syndrome\n• Liver Enlargement\n• Cholecystitis and Cholangitis\n• Hepatitis\n• Liver Cirrhosis and Fibrosis\n• Drug Induced hepatotoxicity\n*Dosage :* Dairy Cattle : 20 - 40 ml in drinking water",
                        'next_session_step' => 91,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 50,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 91
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 91,
                        'step_title' => "*Animatic super Ndama*\nIt’s a specially formulated diet for feeding calves from Day 4 after birth with over 70% milk products, vitamins and minerals for optimum growth and better calf immunity\n*Dosage and feeding recommendation:*\n• Add 1 to 1.25kg of animatic milk replacer to 10litres of warm water (100-125g/litre)",
                        'next_session_step' => 92,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 50,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "\n\nType *0* to go back one step\nType *99* to go back home",
                                'next_session_step' => 92
                            ]

                        ]
                    ],


                ]
            ],
            [
                'session_name' => 'agrovet',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 4,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Are you a stockist? Type in the\nnumber to select an option\nbelow.👇🏾\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'service_methods' => [
                            [
                                'method_name' => 'getCounty',
                                'method_type' => 'get_county',
                            ]
                        ],
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 1,
                                'response_text' => 'Yes',
                                'next_session_step' => 1
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'show_step_id' => 1,
                                'response_text' => 'No',
                                'next_session_step' => 2
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'show_step_id' => 0,
                                'response_text' => "\nType *99* to go back home",
                                'next_session_step' => 20
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "",
                        'next_session_step' => 3,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'service_methods' => [
                            [
                                'method_name' => 'getSupplier',
                                'method_type' => 'get_supplier',
                            ]
                        ],
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => '',
                                'next_session_step' => 3
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 2,
                        'step_title' => "For more details on where to buy the product please call us on 0711045000 or send us a message on 20560 or send us an email on oshochem@oshochem.com\n\n",
                        'next_session_step' => 120,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => true,
                        'previous_session_step' => 0,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "Type *99* to go back home",
                                'next_session_step' => 120
                            ]

                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 3,
                        'step_title' => "",
                        'next_session_step' => 4,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => '',
                                'next_session_step' => 4
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 4,
                        'step_title' => "Are you satisfied?",
                        'next_session_step' => 4,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => '',
                                'next_session_step' => 4
                            ]

                        ]
                    ]

                ]
            ],

            [
                'session_name' => 'contact',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 5,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hi👋🏽, you can contact us through\nthe details below.👇🏾\n\n",
                        'next_session_step' => 1,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "Physical Location: Osho Complex,\nSasio Rd, off Lunga lunga,\nIndustrial Area Nairobi Kenya\nPhone numbers: (+254) 0711 045000\n/ 0732 167000 / 020 3912000\nEmail address:\noshochem@oshochem.com\nSMS Shortcode: 20560\nWebsite url: http://oshochem.com/\nFacebook url:\nhttps://www.facebook.com/OshoChem \nTwitter url:\nhttps://twitter.com/Oshochem \nAlso you can contact us on this\nWhatsApp Business Number:\n0704853383 \n\nType *99* to go back home",
                                'next_session_step' => 1
                            ]
                        ]
                    ]
                ]
            ],
            [
                'session_name' => 'survey',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 6,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Dear Valued Customer, Your Feedback is\nimportant to us! On a scale of 0-10,\nhow has your experience on this platform\nbeen so far?\n(0=Very Unsatisfied, 10=Very Satisfied)",
                        'next_session_step' => 1,
                        'with_input' => 0,
                        'responses' => []
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Thank you for your valuable feedback.🙂\n\nType *99* to go back home",
                        'next_session_step' => 2,
                        'with_input' => 0,
                        'responses' => []
                    ]
                ]
            ],


        ];

        foreach ($bot_sessions as $bot_session) {

            if (!BotSession::where('session_name', $bot_session['session_name'])
                ->where('channel', $bot_session['channel'])
                ->exists()) {

                $bot_session_model = new BotSession();

                $bot_session_model->session_name = $bot_session['session_name'];
                $bot_session_model->session_key_word = $bot_session['session_key_word'];
                $bot_session_model->channel = $bot_session['channel'];

                $bot_session_model->save();
            } else {

                $bot_session_model = BotSession::where('session_name', $bot_session['session_name'])
                    ->where('channel', $bot_session['channel'])
                    ->first();
            }

            foreach ($bot_session['session_steps'] as $session_step) {

                if (!BotSessionStep::where('session_step_key', $session_step['session_step'])
                    ->where('bot_session_id', $bot_session_model->id)
                    ->where('channel', $bot_session['channel'])
                    ->exists()) {

                    $bot_session_step = new BotSessionStep();

                    $bot_session_step->bot_session_id = $bot_session_model->id;
                    $bot_session_step->session_step_key = $session_step['session_step'];
                    $bot_session_step->next_session_step_key = $session_step['next_session_step'];
                    $bot_session_step->channel = $session_step['channel'];
                    $bot_session_step->step_title = $session_step['step_title'];
                    $bot_session_step->is_initial_step = $session_step['is_initial_step'];
                    $bot_session_step->with_input = $session_step['with_input'];
                    $bot_session_step->service_methods = array_key_exists('service_methods', $session_step) ? json_encode($session_step['service_methods']) : null;
                    $bot_session_step->back_to_session = array_key_exists('back_to_session', $session_step) ? $session_step['back_to_session'] : null;
                    $bot_session_step->previous_session_name = array_key_exists('previous_session_name', $session_step) ? $session_step['previous_session_name'] : null;
                    $bot_session_step->allow_back = array_key_exists('allow_back', $session_step) ? $session_step['allow_back'] : null;
                    $bot_session_step->previous_session_step = array_key_exists('previous_session_step', $session_step) ? $session_step['previous_session_step'] : null;
                    $bot_session_step->reply_type = isset($session_step['reply_type']) ? $session_step['reply_type'] : null;
                    $bot_session_step->button_header_type = isset($session_step['button_header_type']) ? $session_step['button_header_type'] : null;
                    $bot_session_step->is_next_step_session = isset($session_step['is_next_step_session']) ? $session_step['is_next_step_session'] : null;
                    $bot_session_step->next_session = isset($session_step['next_session']) ? $session_step['next_session'] : null;


                    $bot_session_step->save();
                } else {

                    $bot_session_step = BotSessionStep::where('session_step_key', $session_step['session_step'])
                        ->where('channel', $bot_session['channel'])
                        ->first();
                }

                foreach ($session_step['responses'] as $response) {

                    if (!BotResponse::where('response_text', $response['response_text'])
                        ->where('bot_session_step_id', $bot_session_step->id)
                        ->where('channel', $bot_session['channel'])
                        ->exists()) {

                        $bot_response = new BotResponse();

                        $bot_response->channel = $response['channel'];
                        $bot_response->bot_session_id = $bot_session_model->id;
                        $bot_response->bot_session_step_id = $bot_session_step->id;
                        $bot_response->key_word = $response['key_word'];
                        $bot_response->response_text = $response['response_text'];
                        $bot_response->show_step_id = $response['show_step_id'];
                        $bot_response->next_session_step = $response['next_session_step'];
                        $bot_response->image_url = isset($response['image_url']) ? $response['image_url'] : null;


                        $bot_response->save();
                    }
                }
            }
        }
    }
}
