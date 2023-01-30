<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Helpers\Helper;
use App\Services\NetworkConnectionService;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    static function loadMoreSentRequests(Request $request)
    {
        $userData = Helper::getLoggedInUserDetails();
        $requestData = $request->all();
        $moreSentRequests = NetworkConnectionService::getSentRequestsOnLoadMore($userData, $requestData);
        echo json_encode($moreSentRequests);
    }

    static function loadMoreRecievedRequests(Request $request)
    {
        $userData = Helper::getLoggedInUserDetails();
        $requestData = $request->all();
        $moreSentRequests = NetworkConnectionService::getRecievedRequestsOnLoadMore($userData, $requestData);
        echo json_encode($moreSentRequests);
    }

    static function cancelSentRequests(Request $request)
    {
        $userData = Helper::getLoggedInUserDetails();
        $requestData = $request->all();
        $cancelSentRequests = NetworkConnectionService::cancelSentRequests($userData, $requestData);
        if($cancelSentRequests)
        {
            echo json_encode(['status' => Constants::TRUE]);
        }
        else 
        {
            echo json_encode(['status' => Constants::FALSE]);
        }
    }

    static function acceptRecievedRequests(Request $request)
    {
        $userData = Helper::getLoggedInUserDetails();
        $requestData = $request->all();
        $acceptRecievedRequests = NetworkConnectionService::acceptRecievedRequests($userData, $requestData);
        if($acceptRecievedRequests)
        {
            echo json_encode(['status' => Constants::TRUE]);
        }
        else 
        {
            echo json_encode(['status' => Constants::FALSE]);
        }
    }
}
