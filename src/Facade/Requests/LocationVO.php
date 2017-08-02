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

/**
 * Class LocationVO
 * @package OutlookRestClient\Facade\Requests
 */
final class LocationVO implements IValueObject
{
    /**
     * @var AddressVO
     */
    private $address;

    /**
     * @var string
     */
    private $location_name;
    /**
     * @var string
     */
    private $location_lat;

    /**
     * @var string
     */
    private $location_lng;

    /**
     * LocationVO constructor.
     * @param string $location_name
     * @param AddressVO $address
     * @param string $location_lat
     * @param string $location_lng
     */
    public function __construct($location_name, AddressVO $address, $location_lat = null, $location_lng = null)
    {
        $this->location_name = $location_name;
        $this->address       = $address;
        $this->location_lat  = $location_lat;
        $this->location_lng  = $location_lng;
    }

    /**
     * @return AddressVO
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getLocationName()
    {
        return $this->location_name;
    }

    /**
     * @return string
     */
    public function getLocationLat()
    {
        return $this->location_lat;
    }

    /**
     * @return string
     */
    public function getLocationLng()
    {
        return $this->location_lng;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [

            "DisplayName"  => $this->location_name,
            'Address'      => $this->address->toArray(),
            "Coordinates"          => [
                "Latitude"  => $this->location_lat,
                "Longitude" => $this->location_lng,
            ],
            "LocationEmailAddress" => null
        ];
    }
}