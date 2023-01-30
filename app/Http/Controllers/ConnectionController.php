<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Helpers\Helper;
use App\Services\NetworkConnectionService;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    static function loadMoreConnections(Request $request)
    {
        $userData = Helper::getLoggedInUserDetails();
        $requestData = $request->all();
        $connections = NetworkConnectionService::getConnectionsOnLoadMore($userData, $requestData);
        echo json_encode($connections);
    }

    static function removeConnections(Request $request)
    {
        $userData = Helper::getLoggedInUserDetails();
        $requestData = $request->all();
        $removeConnections = NetworkConnectionService::removeConnections($userData, $requestData);
        if($removeConnections)
        {
            echo json_encode(['status' => Constants::TRUE]);
        }
        else 
        {
            echo json_encode(['status' => Constants::FALSE]);
        }
    }

    static function loadMoreCommonConnections(Request $request)
    {
        $userData = Helper::getLoggedInUserDetails();
        $requestData = $request->all();
        $commonConnections = NetworkConnectionService::getCommonConnectionsOnLoadMore($userData, $requestData);
        echo json_encode($commonConnections);
    }
}
