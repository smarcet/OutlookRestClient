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

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Component\Console\Exception\LogicException;

/**
 * Class TokenManager
 * @package OutlookRestClient\Facade
 */
final class TokenManager implements ITokenManager
{
    /**
     * @var array
     */
    private $access_token = null;

    /**
     * @var callable
     */
    private $token_callback;

    /**
     * @param array $access_token
     */
    public function storeToken(array $access_token){
        $this->access_token = $access_token;
    }

    public function clearToken(){
        $this->access_token = null;
    }

    /**
     * @return bool
     */
    public function isAccessTokenExpired(){
        if(is_null($this->access_token) || !isset($this->access_token['expires'])) return true;
        // Check if token is expired
        //Get current time + 5 minutes (to allow for time differences)
        $now   = time() + ITokenManager::TimeSkew;
        return $this->access_token['expires'] <= $now ;
    }

    /**
     * @param null|string $refresh_token
     * @return array|null
     * @throws LogicException
     */
    public function fetchAccessTokenWithRefreshToken($refresh_token = null){
        // Token is expired (or very close to it)
        // so let's refresh
        if(empty($refresh_token) && !is_null($this->access_token) && isset($this->access_token['refresh_token']));
            $refresh_token =  $this->access_token['refresh_token'];

        if (empty($refresh_token)) {
            throw new LogicException(
                'refresh token is null'
            );
        }
        // Initialize the OAuth client
        $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => getenv('OUTLOOK_OAUTH_APP_ID'),
            'clientSecret'            => getenv('OUTLOOK_OAUTH_APP_PASSWORD'),
            'urlAuthorize'            => getenv('OUTLOOK_OAUTH_AUTHORITY').getenv('OUTLOOK_OAUTH_AUTHORIZE_ENDPOINT'),
            'urlAccessToken'          => getenv('OUTLOOK_OAUTH_AUTHORITY').getenv('OUTLOOK_OAUTH_TOKEN_ENDPOINT'),
            'urlResourceOwnerDetails' => '',
            'scopes'                  => getenv('OUTLOOK_OAUTH_SCOPES')
        ]);

        try {
            $new_token = $oauthClient->getAccessToken('refresh_token', [
                'refresh_token' =>$refresh_token
            ]);

            $new_token = $new_token->jsonSerialize();
            // Store the new values
            $this->storeToken($new_token);
            if ($this->token_callback) {
                call_user_func($this->token_callback, $new_token);
            }
            return $new_token;
        }
        catch (IdentityProviderException $e) {
            $this->clearToken();
            return null;
        }
    }

    /**
     * @return array
     */
    public function getAccessToken() {

        if(is_null($this->access_token)) return null;

        if ($this->isAccessTokenExpired()) {
           $this->fetchAccessTokenWithRefreshToken();
        }

        // Token is still valid, just return it
        return $this->access_token;

    }

    /**
     * sets function to be called when an access token is fetched
     * @param callable $token_callback
     * @return void
     */
    public function setTokenCallback(callable $token_callback){
        $this->token_callback = $token_callback;
    }
}