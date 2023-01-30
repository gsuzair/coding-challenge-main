<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Request;
use App\Models\User;

class NetworkConnectionService
{
    public static function getNetworkConnectionCount($userData)
    {
        $networkConnectionData = [];
        $networkConnectionData['suggestion_count'] = User::getSuggestionsCount($userData);
        $networkConnectionData['sent_request_count'] = Request::getSentRequestsCount($userData);
        $networkConnectionData['received_requests_count'] = Request::getReceivedRequestsCount($userData);
        $networkConnectionData['connections_count'] = Request::getConnectionsCount($userData);
    
        return $networkConnectionData;
    }

    public static function getSuggestionData($userData)
    {
        return User::getSuggestionsData($userData);
    }

    public static function getSuggestionOnLoadMore($userData, $requestData)
    {
        return User::getSuggestionOnLoadMore($userData, $requestData);
    }

    public static function connectSuggestion($userData, $requestData)
    {
        return Request::connectSuggestion($userData, $requestData);
    }

    public static function getSentRequestData($userData)
    {
        $requestedTo = Request::getSentRequestData($userData);
        return User::getSentRequestUserData($requestedTo);
    }

    public static function getSentRequestsOnLoadMore($userData, $requestData)
    {
        return User::getSentRequestsOnLoadMore($userData, $requestData);
    }

    public static function cancelSentRequests($userData, $requestData)
    {
        return Request::cancelSentRequests($userData, $requestData);
    }
    
    public static function getRecievedRequestData($userData)
    {
        $requestedBy = Request::getRecievedRequestData($userData);
        return User::getRecievedRequestUserData($requestedBy);
    }

    public static function getRecievedRequestsOnLoadMore($userData, $requestData)
    {
        return User::getRecievedRequestsOnLoadMore($userData, $requestData);
    }

    public static function acceptRecievedRequests($userData, $requestData)
    {
        return Request::acceptRecievedRequests($userData, $requestData);
    }

    public static function getConnectionData($userData)
    {
        $connectionsData = [];
        $connections = Request::getConnectionData($userData);
        foreach($connections as $connection)
        {
            if($connection->requester_id != $userData['user_id'])
            {
                array_push($connectionsData, $connection->requester_id);
            }
            if($connection->requested_to_id != $userData['user_id'])
            {
                array_push($connectionsData, $connection->requested_to_id);
            }
        }
        $connectionsData = array_unique($connectionsData);
        $allConnections = User::getConnectionUserData($connectionsData);
        foreach($allConnections as $key => $connection)
        {
            $allConnections[$key]['common'] = Request::connectionsInCommon($userData, $connection['id']);
        }
        return $allConnections;
    }

    public static function getConnectionsOnLoadMore($userData, $requestData)
    {
        $moreConnections = User::getConnectionsOnLoadMore($userData, $requestData);
        foreach($moreConnections as $key => $connection)
        {
            $moreConnections[$key]['common'] = Request::connectionsInCommon($userData, $connection['id']);
        }
        return $moreConnections;
    }

    public static function removeConnections($userData, $requestData)
    {
        return Request::removeConnections($userData, $requestData);
    }

    public static function getCommonConnectionsOnLoadMore($userData, $requestData)
    {
        return User::getCommonConnectionsOnLoadMore($userData, $requestData);
    }
}
