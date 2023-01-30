<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Helpers\Helper;
use App\Services\NetworkConnectionService;
use Illuminate\Http\Request;

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
        $userData = Helper::getLoggedInUserDetails();
        $networkConnectionCounts = NetworkConnectionService::getNetworkConnectionCount($userData);
        $suggestionData = NetworkConnectionService::getSuggestionData($userData);
        $sentRequestData = NetworkConnectionService::getSentRequestData($userData);
        $recievedRequestData = NetworkConnectionService::getRecievedRequestData($userData);
        $connectionData = NetworkConnectionService::getConnectionData($userData);
        $sent = Constants::SENT;
        $recieved = Constants::RECEIVED;
        return view('home', compact(
            'networkConnectionCounts', 
            'suggestionData', 
            'sentRequestData',
            'recievedRequestData',
            'connectionData',
            'sent',
            'recieved',
            'userData',
        ));
    }
    
    public function dummy()
    {
        return view('dummy');
    }
}
