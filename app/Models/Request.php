<?php

namespace App\Models;

use App\Helpers\Constants;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\TextUI\XmlConfiguration\Constant;

class Request extends Model
{
    use HasFactory;
    protected $guarded = [];

    static function getSuggestionsConnectionsCount($userData)
    {
        $requester = self::where('requester_id', $userData['user_id'])
        ->pluck('requested_to_id')
        ->toArray();

        $requested = self::where('requested_to_id', $userData['user_id'])
        ->pluck('requester_id')
        ->toArray();

        $connections = array_merge( $requester , $requested );
        array_push($connections, $userData['user_id']);
        $connections = array_unique($connections);

        return $connections;
    }

    static function getSentRequestsCount($userData)
    {
        return self::select('requested_to_id')
        ->where('requester_id', $userData['user_id'])
        ->where('request_status', Constants::REQUESTED)
        ->count();
    }

    static function getReceivedRequestsCount($userData)
    {
        return self::select('requester_id')
        ->where('requested_to_id', $userData['user_id'])
        ->where('request_status', Constants::REQUESTED)
        ->count();
    }

    static function getConnectionsCount($userData)
    {
        $connectionsCount = self::select('id')
        ->where('request_status', Constants::ACCEPTED);

        $connectionsCount->where(function ($query) use ($userData) {
            $query->orWhere('requester_id', $userData['user_id'])
                ->orWhere('requested_to_id', $userData['user_id']);
        });

        $connectionsCount = $connectionsCount->count();

        return $connectionsCount;
    }

    static function connectSuggestion($userData, $requestData)
    {
        return self::create([
            'requester_id' => $userData['user_id'],
            'requested_to_id' => $requestData['id'],
            'request_status' => Constants::REQUESTED,
        ])->id;
    }

    static function getSentRequestData($userData)
    {
        return self::where('requester_id', $userData['user_id'])
        ->where('request_status', Constants::REQUESTED)
        ->pluck('requested_to_id')
        ->toArray();
    }

    static function getRecievedRequestData($userData)
    {
        return self::where('requested_to_id', $userData['user_id'])
        ->where('request_status', Constants::REQUESTED)
        ->pluck('requester_id')
        ->toArray();
    }

    static function cancelSentRequests($userData, $requestData)
    {
        return self::where('requester_id', $userData['user_id'])
        ->where('requested_to_id',  $requestData['id'])
        ->where('request_status', Constants::REQUESTED)
        ->delete();
    }

    static function acceptRecievedRequests($userData, $requestData)
    {
        return self::where('requested_to_id', $userData['user_id'])
        ->where('requester_id',  $requestData['id'])
        ->update([
            'request_status' => Constants::ACCEPTED
        ]);
    }

    static function removeConnections($userData, $requestData)
    {
        $query = self::where('requester_id', $userData['user_id'])
        ->where('requested_to_id',  $requestData['id'])
        ->where('request_status', Constants::ACCEPTED)
        ->delete();
        if(!$query)
        {
            $query = self::where('requested_to_id', $userData['user_id'])
            ->where('requester_id',  $requestData['id'])
            ->where('request_status', Constants::ACCEPTED)
            ->delete();
        }
        return $query;
    }

    static function getConnectionData($userData)
    {
        $connectionsData = self::select('id', 'requester_id', 'requested_to_id')
        ->where('request_status', Constants::ACCEPTED);

        $connectionsData->where(function ($query) use ($userData) {
            $query->orWhere('requester_id', $userData['user_id'])
                ->orWhere('requested_to_id', $userData['user_id']);
        });

        $connectionsData = $connectionsData->get();

        return $connectionsData;
    }
    
    static function getConnectionOnLoadMore($userData)
    {
        $connectionsData = self::select('id', 'requester_id', 'requested_to_id')
        ->where('request_status', Constants::ACCEPTED);

        $connectionsData->where(function ($query) use ($userData) {
            $query->orWhere('requester_id', $userData['user_id'])
                ->orWhere('requested_to_id', $userData['user_id']);
        });

        $connectionsData = $connectionsData->get();

        return $connectionsData;
    }

    static function connectionsInCommon($userData, $friendId)
    {
        $commonConnections = Helper::commonConnections($userData, $friendId);
        return $commonConnections;
    }

    static function getCommonConnectionData($userData, $friendId, $limit)
    {
        $connectionInCommonMore = [];
        $commonConnections = Helper::commonConnections($userData, $friendId);

        foreach($commonConnections as $key => $cc)
        {
            if($key > $limit)
            {
                if(count($connectionInCommonMore) < Constants::LOAD_MORE)
                {
                    $getCommonConnectionUserDetails = User::getCommonConnectionUserDetails($cc);
                    array_push($connectionInCommonMore, $getCommonConnectionUserDetails);
                }
            }
        }
        return $connectionInCommonMore;
    }
}
