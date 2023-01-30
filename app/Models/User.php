<?php

namespace App\Models;

use App\Helpers\Constants;
use App\Helpers\Helper;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPUnit\TextUI\XmlConfiguration\Constant;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = [];

    static function getSuggestionsCount($userData)
    {
        $connectedTo = Request::getSuggestionsConnectionsCount($userData);
        return self::select('id')
            ->whereNotIn('id', $connectedTo)
            ->count();
    }

    static function getSuggestionsData($userData)
    {
        $connectedTo = Request::getSuggestionsConnectionsCount($userData);
        return self::select('id', 'name', 'email')
            ->whereNotIn('id', $connectedTo)
            ->get()
            ->toArray();
    }

    static function getSuggestionOnLoadMore($userData, $requestData)
    {
        $connectedTo = Request::getSuggestionsConnectionsCount($userData);
        return self::select('id', 'name', 'email')
            ->whereNotIn('id', $connectedTo)
            ->skip($requestData['suggestion_limit'])
            ->take(Constants::LOAD_MORE)
            ->get()
            ->toArray();
    }

    static function getSentRequestUserData($requestedTo)
    {
        return Helper::getUserData($requestedTo);
    }

    static function getRecievedRequestUserData($requestedBy)
    {
        return Helper::getUserData($requestedBy);
    }
    
    static function getConnectionUserData($connections)
    {

        return Helper::getUserData($connections);
    }

    static function getSentRequestsOnLoadMore($userData, $requestData)
    {
        $requestedTo = Request::getSentRequestData($userData);
        return self::select('id', 'name', 'email')
            ->whereIn('id', $requestedTo)
            ->skip($requestData['sr_limit'])
            ->take(Constants::LOAD_MORE)
            ->get()
            ->toArray();
    }

    static function getRecievedRequestsOnLoadMore($userData, $requestData)
    {
        $requestedBy = Request::getRecievedRequestData($userData);
        return self::select('id', 'name', 'email')
            ->whereIn('id', $requestedBy)
            ->skip($requestData['rr_limit'])
            ->take(Constants::LOAD_MORE)
            ->get()
            ->toArray();
    }

    static function getConnectionsOnLoadMore($userData, $requestData)
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
            $connectionsData = array_unique($connectionsData);
        }
        return self::select('id', 'name', 'email')
            ->whereIn('id', $connectionsData)
            ->skip($requestData['connection_limit'])
            ->take(Constants::LOAD_MORE)
            ->get()
            ->toArray();
    }

    static function getCommonConnectionUserDetails($userId)
    {
        return self::select('id', 'name', 'email')
        ->where('id', $userId)
        ->first()->toArray();
    }

    static function getCommonConnectionsOnLoadMore($userData, $requestData)
    {
        $connectionsData = []; 
        $connections = Request::getCommonConnectionData($userData, $requestData['id'], $requestData['connection_in_common_limit']);
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
            $connectionsData = array_unique($connectionsData);
        }
        return self::select('id', 'name', 'email')
            ->whereIn('id', $connectionsData)
            ->skip($requestData['connection_in_common_limit'])
            ->take(Constants::LOAD_MORE)
            ->get()
            ->toArray();
    }
}
