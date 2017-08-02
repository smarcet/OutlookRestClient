<?php namespace OutlookRestClient\Facade\Requests;
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
use DateTime;
use DateTimeZone;
use phpDocumentor\Reflection\Location;

/**
 * Class EventVO
 * @package OutlookRestClient\Facade
 */
final class EventVO implements IValueObject
{
    const DateTimeFormat = "Y-m-d\TH:i:s";
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $body_preview;

    /**
     * @var DateTime
     */
    private $start;

    /**
     * @var DateTime
     */
    private $end;

    /**
     * @var DateTimeZone
     */
    private $time_zone;

    /**
     * @var LocationVO
     */
    private $location;

    /**
     * EventVO constructor.
     * @param string $subject
     * @param string $body
     * @param DateTime $start
     * @param DateTime $end
     * @param DateTimeZone $time_zone
     * @param LocationVO $location
     */
    public function __construct
    (
        $subject,
        $body,
        DateTime $start,
        DateTime $end,
        DateTimeZone $time_zone = null,
        LocationVO $location   = null
    )
    {
        $this->subject          = $subject;
        $this->body             = $body;
        $this->start            = $start;
        $this->end              = $end;
        $this->time_zone        = $time_zone;
        $this->location         = $location;

        if(is_null($this->time_zone)){
            $this->time_zone = new DateTimeZone('UTC');
        }
    }

    /**
     * @return array
     */
    public function toArray(){
        return [
            'Subject' => $this->subject,
            "Body" => [
                "ContentType" => "HTML",
                "Content"     => $this->body
            ],
            "BodyPreview" => $this->body_preview,
            // https://developer.microsoft.com/en-us/graph/docs/api-reference/beta/resources/datetimetimezone
            "Start" => [
                "DateTime" => $this->start->format(self::DateTimeFormat),
                "TimeZone" =>  $this->time_zone->getName()
            ],
            "End" => [
                "DateTime" => $this->end->format(self::DateTimeFormat),
                "TimeZone" => $this->time_zone->getName()
            ],
           "Location" =>  $this->location->toArray()
        ];
    }
}