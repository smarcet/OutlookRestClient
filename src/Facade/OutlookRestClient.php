<?php namespace OutlookRestClient\Facade;
/**
 * Copyright 2017 OpenStack Foundation
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 **/
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use OutlookRestClient\Facade\Responses\CalendarCollectionResponse;
use OutlookRestClient\Facade\Responses\CalendarResponse;
use OutlookRestClient\Facade\Responses\ErrorResponse;
use OutlookRestClient\Facade\Responses\EventResponse;
use OutlookRestClient\Facade\Utils\HttpMethods;
use OutlookRestClient\IOutlookRestClient;
use OutlookRestClient\Facade\Requests\CalendarVO;
use OutlookRestClient\Facade\Requests\EventVO;

/**
 * Class OutlookRestClient
 * @see https://docs.microsoft.com/en-us/outlook/rest/compare-graph-outlook
 * @package OutlookRestClient\Facade
 */
final class OutlookRestClient implements IOutlookRestClient
{

    /**
     * @var string
     */
    const BaseUrl = 'https://outlook.office.com/api/v2.0/';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var int
     */
    private $timeout = 60;

    /**
     * @var null|ITokenManager
     */
    private $token_manager = null;

    /**
     * OutlookRestClient constructor.
     */
    public function __construct()
    {
        $this->client        = new Client(['base_uri' => self::BaseUrl]);
        $this->token_manager = new TokenManager();
    }

    /**
     * @return array
     */
    private function getDefaultHeaders()
    {
        $access_token = $this->token_manager->getAccessToken();
        if(is_null($access_token)) throw new \LogicException("access token is null!");
        return [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $access_token['access_token']
        ];
    }

    /**
     * @param CalendarVO $calendar
     * @return CalendarResponse|ErrorResponse
     */
    public function createCalendar(CalendarVO $calendar)
    {
        $http_request = new Request
        (
            HttpMethods::Post,
            'me/calendars',
            $this->getDefaultHeaders(),
            json_encode($calendar->toArray())
        );

        try{
            $http_response =  $this->client->send($http_request, [
                'timeout'  => $this->timeout,
            ]);
            return new CalendarResponse((string)$http_response->getBody());
        }
        catch (ClientException $ex){
            return new ErrorResponse( (string)$ex->getResponse()->getBody());
        }
    }

    /**
     * @param string $calendar_id
     * @param CalendarVO $calendar
     * @return  CalendarResponse|ErrorResponse
     */
    public function updateCalendar($calendar_id, CalendarVO $calendar)
    {
        $http_request = new Request
        (
            HttpMethods::Patch,
            "me/calendars/{$calendar_id}",
            $this->getDefaultHeaders(),
            json_encode($calendar->toArray())
        );

        try{
            $http_response =  $this->client->send($http_request, [
                'timeout'  => $this->timeout,
            ]);
            return new CalendarResponse((string)$http_response->getBody());
        }
        catch (ClientException $ex){
            return new ErrorResponse( (string)$ex->getResponse()->getBody());
        }
    }

    /**
     * @param string $calendar_id
     * @return bool|ErrorResponse
     */
    public function deleteCalendar($calendar_id)
    {
        $http_request = new Request
        (
            HttpMethods::Delete,
            "me/calendars/{$calendar_id}",
            $this->getDefaultHeaders()
        );

        try{
            $http_response =  $this->client->send($http_request, [
                'timeout'  => $this->timeout,
            ]);
            return $http_response->getStatusCode() == 204;
        }
        catch (ClientException $ex){
            return new ErrorResponse((string)$ex->getResponse()->getBody());
        }
    }

    /**
     * @param string $calendar_id
     * @param EventVO $event
     * @return ErrorResponse|EventResponse
     */
    public function createEvent($calendar_id, EventVO $event)
    {
        $http_request = new Request
        (
            HttpMethods::Post,
            "me/calendars/{$calendar_id}/events",
            $this->getDefaultHeaders(),
            json_encode($event->toArray())
        );

        try{
            $http_response =  $this->client->send($http_request, [
                'timeout'  => $this->timeout,
            ]);
            return new EventResponse((string)$http_response->getBody());
        }
        catch (ClientException $ex){
            return new ErrorResponse( (string)$ex->getResponse()->getBody());
        }
    }

    /**
     * @param string $event_id
     * @param EventVO $event
     * @return EventResponse|ErrorResponse
     */
    public function updateEvent($event_id, EventVO $event)
    {
        $http_request = new Request
        (
            HttpMethods::Patch,
            "me/events/{$event_id}",
            $this->getDefaultHeaders(),
            json_encode($event->toArray())
        );

        try{
            $http_response =  $this->client->send($http_request, [
                'timeout'  => $this->timeout,
            ]);
            return new EventResponse((string)$http_response->getBody());
        }
        catch (ClientException $ex){
            return new ErrorResponse( (string)$ex->getResponse()->getBody());
        }
    }

    /**
     * @param string $event_id
     * @return bool|ErrorResponse
     */
    public function deleteEvent($event_id)
    {
        $http_request = new Request
        (
            HttpMethods::Delete,
            "me/events/{$event_id}",
            $this->getDefaultHeaders()
        );

        try{
            $http_response =  $this->client->send($http_request, [
                'timeout'  => $this->timeout,
            ]);
            return $http_response->getStatusCode() == 204;
        }
        catch (ClientException $ex){
            return new ErrorResponse((string)$ex->getResponse()->getBody());
        }
    }

    public function setAccessToken(array $access_token = null)
    {
        $this->token_manager->storeToken($access_token);
    }

    /**
     * @return mixed
     */
    public function isAccessTokenExpired()
    {
       return $this->token_manager->isAccessTokenExpired();
    }

    /**
     * @return CalendarCollectionResponse|ErrorResponse
     */
    public function getCalendars()
    {

        $http_request = new Request
        (
            HttpMethods::Get,
            'me/calendars',
            $this->getDefaultHeaders()
        );

        try{
            $http_response =  $this->client->send($http_request, [
                'timeout'  => $this->timeout,
            ]);
            return new CalendarCollectionResponse((string)$http_response->getBody());
        }
        catch (ClientException $ex){
            return new ErrorResponse( (string)$ex->getResponse()->getBody());
        }
    }

    /**
     * sets function to be called when an access token is fetched
     * @param callable $token_callback
     * @return void
     */
    public function setTokenCallback(callable $token_callback)
    {
        $this->token_manager->setTokenCallback($token_callback);
    }
}