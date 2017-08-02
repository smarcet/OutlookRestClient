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


/**
 * Interface ITokenManager
 * @package OutlookRestClient\Facade
 */
interface ITokenManager
{
    const TimeSkew = 300;

    /**
     * @param array $access_token
     */
    public function storeToken(array $access_token);

    /**
     * @return bool
     */
    public function isAccessTokenExpired();

    /**
     * @param null|string $refresh_token
     * @return array|null
     * @throws \LogicException
     */
    public function fetchAccessTokenWithRefreshToken($refresh_token = null);

    /**
     * @return array
     */
    public function getAccessToken();

    /**
     * sets function to be called when an access token is fetched
     * @param callable $token_callback
     * @return void
     */
    public function setTokenCallback(callable $token_callback);

    /**
     * @return void
     */
    public function clearToken();
}