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
 * Class AbstractResponse
 * @package OutlookRestClient\Facade\Responses
 */
abstract class AbstractResponse
{
    /**
     * @var array
     */
    protected $content = [];

    /**
     * AbstractResponse constructor.
     * @param string $body
     */
    public function __construct($body)
    {
        $this->content = json_decode($body, true);
    }

    /**
     * @param string $prop_name
     * @return mixed|null
     */
    protected function getProperty($prop_name){
        return isset($this->content[$prop_name])? $this->content[$prop_name] : null;
    }
    /**
     * @return string
     */
    public function getId(){
        return $this->getProperty(Properties::Id);
    }

    /**
     * @return string
     */
    public function getChangeKey(){
        return $this->getProperty(Properties::ChangeKey);
    }

    /**
     * @return string
     */
    public function getETag(){
        return $this->getProperty(Properties::ETag);
    }

    /**
     * @return string
     */
    public function getDataId(){
        return $this->getProperty(Properties::DataId);
    }

    /**
     * @return string
     */
    public function getContext(){
        return $this->getProperty(Properties::Context);
    }
}