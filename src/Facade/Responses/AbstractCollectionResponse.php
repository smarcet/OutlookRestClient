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
 * Class AbstractCollectionResponse
 * @package OutlookRestClient\Facade\Responses
 */
abstract class AbstractCollectionResponse extends AbstractResponse
{
    /**
     * @var array
     */
    protected $entries;

    public function __construct($body)
    {
        parent::__construct($body);
        foreach ($this->content['value'] as $element){
            $this->entries[] = $this->buildSingleResponse(json_encode($element));
        }
    }

    /**
     * @param string $body
     * @return AbstractResponse
     */
    abstract protected function buildSingleResponse($body);

    /**
     * @return AbstractResponse[]
     */
    public function getEntries(){
        return $this->entries;
    }
}