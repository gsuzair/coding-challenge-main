<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Helpers\Helper;
use App\Models\User;
use App\Services\NetworkConnectionService;
use Illuminate\Http\Request;

class SuggestionsController extends Controller
{
    static function loadMoreSuggestions(Request $request)
    {
        $userData = Helper::getLoggedInUserDetails();
        $requestData = $request->all();
        $moreSuggestions = NetworkConnectionService::getSuggestionOnLoadMore($userData, $requestData);
        echo json_encode($moreSuggestions);
    }

    static function connectSuggestions(Request $request)
    {
        $userData = Helper::getLoggedInUserDetails();
        $requestData = $request->all();
        
        $connectSuggestion = NetworkConnectionService::connectSuggestion($userData, $requestData);
        if($connectSuggestion)
        {
            echo json_encode(['status' => Constants::TRUE]);
        }
        else 
        {
            echo json_encode(['status' => Constants::FALSE]);
        }
    }
}
