<?php namespace OutlookRestClient\Facade\Responses;
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
 * Class EventResponse
 * @package OutlookRestClient\Facade\Responses
 */
final class EventResponse extends AbstractResponse
{

    /**
     * @return string|null
     */
    public function getOriginalStartTimeZone(){
        return $this->getProperty("OriginalStartTimeZone");
    }

    /**
     * @return string|null
     */
    public function getOriginalEndTimeZone(){
        return $this->getProperty("OriginalEndTimeZone");
    }

    /**
     * @return string|null
     */
    public function getICalUID(){
        return $this->getProperty("iCalUID");
    }

    /**
     * @return string|null
     */
    public function getCreatedDateTime(){
        return $this->getProperty("CreatedDateTime");
    }

    /**
     * @return string|null
     */
    public function getLastModifiedDateTime(){
        return $this->getProperty("LastModifiedDateTime");
    }

    /**
     * @return string|null
     */
    public function getType(){
        return $this->getProperty("Type");
    }

}