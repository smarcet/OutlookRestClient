<?php namespace OutlookRestClient;
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

use OutlookRestClient\Facade\Requests\CalendarVO;
use OutlookRestClient\Facade\Requests\EventVO;
use OutlookRestClient\Facade\Responses\CalendarCollectionResponse;
use OutlookRestClient\Facade\Responses\CalendarResponse;
use OutlookRestClient\Facade\Responses\ErrorResponse;
use OutlookRestClient\Facade\Responses\EventResponse;

/**
 * Interface IOutlookRestClient
 * @package OutlookRestClient
 */
interface IOutlookRestClient
{
    /**
     * @param array|null $access_token
     * @return void
     */
    public function setAccessToken(array $access_token = null);

    /**
     * @return bool
     */
    public function isAccessTokenExpired();

    /**
     * sets function to be called when an access token is fetched
     * @param callable $token_callback
     * @return void
     */
    public function setTokenCallback(callable $token_callback);

    /**
     * @param CalendarVO $calendar
     * @return CalendarResponse|ErrorResponse
     */
    public function createCalendar(CalendarVO $calendar);

    /**
     * @param string $calendar_id
     * @param CalendarVO $calendar
     * @return  CalendarResponse|ErrorResponse
     */
    public function updateCalendar($calendar_id, CalendarVO $calendar);

    /**
     * @return CalendarCollectionResponse|ErrorResponse
     */
    public function getCalendars();

    /**
     * @see https://stackoverflow.com/questions/31923669/office-365-unified-api-error-when-deleting-a-calendar
     * @see https://stackoverflow.com/questions/44597230/office365-calendar-rest-api-cannot-delete-calendars
     * @param string $calendar_id
     * @return bool|ErrorResponse
     */
    public function deleteCalendar($calendar_id);

    /**
     * @param string $calendar_id
     * @param EventVO $event
     * @return EventResponse|ErrorResponse
     */
    public function createEvent($calendar_id, EventVO $event);

    /**
     * @param string $event_id
     * @param EventVO $event
     * @return EventResponse|ErrorResponse
     */
    public function updateEvent($event_id, EventVO $event);

    /**
     * @see https://stackoverflow.com/questions/31923669/office-365-unified-api-error-when-deleting-a-calendar
     * @see https://stackoverflow.com/questions/44597230/office365-calendar-rest-api-cannot-delete-calendars
     * @param string $event_id
     * @return bool|ErrorResponse
     */
    public function deleteEvent($event_id);
}