<?php

namespace App\Http\Controllers;

use Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $conversations = Chat::conversations(Chat::conversations()->conversation)
            ->setParticipant(auth()->user())
            ->get()
            ->toArray()['data'];

        $conversations = Arr::pluck($conversations, 'conversation_id');


        $data = [
            'conversations' => array_map('intval', $conversations),
            'participant' => [
                'id' => auth()->user()->id,
                'type' => get_class(auth()->user())
            ]
        ];

        return view('home', $data);
    }
}
