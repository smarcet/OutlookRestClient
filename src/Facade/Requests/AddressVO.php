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
 * Class AddressVO
 * @package OutlookRestClient\Facade\Requests
 */
final class AddressVO implements IValueObject
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $postal_code;

    /**
     * AddressVO constructor.
     * @param string $street
     * @param string $city
     * @param string $state
     * @param string $country
     * @param string $postal_code
     * @param string $type
     */
    public function __construct($street, $city, $state, $country, $postal_code = null, $type = null)
    {
        $this->street      = $street;
        $this->city        = $city;
        $this->state       = $state;
        $this->country     = $country;
        $this->postal_code = $postal_code;
        $this->type        = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'Type'            => $this->type,
            'Street'          => $this->street,
            'City'            => $this->city,
            'State'           => $this->state,
            'CountryOrRegion' => $this->country,
            'PostalCode'      => $this->postal_code,
        ];
    }
}