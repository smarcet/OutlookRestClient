<?php
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

use OutlookRestClient\IOutlookRestClient;
use OutlookRestClient\Facade\OutlookRestClient;
use OutlookRestClient\Facade\Requests\CalendarVO;
use OutlookRestClient\Facade\Requests\EventVO;
use OutlookRestClient\Facade\Requests\LocationVO;
use OutlookRestClient\Facade\Requests\AddressVO;
/**
 * Class FacadeTest
 */
final class FacadeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var IOutlookRestClient
     */
    private static $client;

    private static function generateRandomResourceId(){
        return md5(uniqid(mt_rand(), true));
    }

    public static function setUpBeforeClass()
    {
        $dotenv = new Dotenv\Dotenv(__DIR__.'/../');
        $dotenv->load();
        self::$client = new OutlookRestClient();
        self::$client->setTokenCallback(function($access_token){
            echo "renewed accesss token!";
        });
        $access_token = <<< JSON
{"token_type":"Bearer","scope":"https:\/\/outlook.office.com\/User.Read https:\/\/outlook.office.com\/Calendars.ReadWrite","ext_expires_in":0,"id_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6IjFMVE16YWtpaGlSbGFfOHoyQkVKVlhlV01xbyJ9.eyJ2ZXIiOiIyLjAiLCJpc3MiOiJodHRwczovL2xvZ2luLm1pY3Jvc29mdG9ubGluZS5jb20vOTE4ODA0MGQtNmM2Ny00YzViLWIxMTItMzZhMzA0YjY2ZGFkL3YyLjAiLCJzdWIiOiJBQUFBQUFBQUFBQUFBQUFBQUFBQUFGbzdMX1c4Y0FyM0ZyWWtSVmhJd3dRIiwiYXVkIjoiNDU5Mzg1MzUtYzk2Ni00NGI5LTlmOGYtMmMzZDQzMmRkMzAyIiwiZXhwIjoxNTAxNzc0Mjc4LCJpYXQiOjE1MDE2ODc1NzgsIm5iZiI6MTUwMTY4NzU3OCwibmFtZSI6IlNlYmFzdGlhbiBNYXJjZXQiLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiJ0ZXN0MTU3NUBob3RtYWlsLmNvbSIsIm9pZCI6IjAwMDAwMDAwLTAwMDAtMDAwMC0zZjk1LTkxNzI5ZDQ5MGQ4OSIsInRpZCI6IjkxODgwNDBkLTZjNjctNGM1Yi1iMTEyLTM2YTMwNGI2NmRhZCIsImFpbyI6IkRjZmdYUndYSVU0UEw3NUdBQ2VYNml1MGhFQm9yVk4qVFpJVFNVSWNhSXVTMVg3a29tOU1BczBNVCo4NGlOWnQqN3RyR05tT1MyaVlBNTJXNHRCbWU1MDhHYW42azZlaDNEUGVDWEI0OEshUiJ9.kF06NqO4o30l8wZr6ESn7Aw-s0JYA_awHtrQw-nS15M6VtvR0aa9aHi2wprZQWkHWo0YjukPY8GnSwibH7WHEw-CAWoE0AH38EmE1Qw_pMDaH4c23DpS1icwE4jgrwI-DRh98gi2orcLWCNdNmmvsXStoTjtn3EcBDTDyDmxh-Ad6g9qvXdhZ7StdcBe4JucycLZixTC4u1TMeodqvb6YRDT3dtr0lEV1l_LBevc8qVIFyr-IWbdIYzhAIxJ_-5OTKzJq-02X55469kU6nPYyNSn_LDGs8BUtS9y8uJyHqWavCXZceNFnF-XeFmLX3jqikRzEl9d0PRlgEPpYsQ_XA","access_token":"EwAIA+l3BAAUWm1xSeJRIJK6txKjBez4GzapzqMAAfV8eI2DZ3PViEuVPV9tiiC2o3XphhFSBXy8zex1AyCWMKgNWmHTdOg10qAwAm7wNqzE1ljuDK\/\/bLezClZqZT0ty9vmhsB+KPLWf5SddQuZ\/ebrEJX3jvppQ+pTeG1\/q0s8ug4B9aJJ1cVPCDKT6furVg9a0c32y7TNabWv0lq8TFBUEN\/BRsfz1tWiYjKZIlNmJpRTGIvBUn1cl5EHRiA1kvlqPRWzI2f20z3JYnFpBp1WFlO2NIhjzfHeQsFMx3pfEFG1GlFQL+nm7MZphmt68xRpfGDp5JZ\/UgVOUUW3suSUA03g6R5FbR8dtwJv932IWj9zHxNKoQXZPQJlhaUDZgAACDD\/rNglm8He2AFvyfpvODZOGWBKeLuXUkVkkK2f\/AsGNRaYZWylVA+E6vlKzrrxWlHVmQTO7VvMvtxFIgz2Sc6KKRcnTh\/X05008RfqS9IMsMDjt\/dVANhmi\/L8\/i3zeElP3jozpcdo7nTwAHoCO2Ep\/4IhuHhfbbVU\/m\/w\/gK11q0T\/c0VM4+nFBwb9nyAP1axLNcy0OEQ1Z\/JBFnlLtuaABuERMFYPCPLMV\/SW5tFdAJ2VLcEiXh1wqEyxC9SQY5A+aNbslSeGHBuVnxAhtVqSSAcXzmaVj8VDMWstFcs5ZCJ7OuQVExzU4wCD0NPZIkwV6RpesBea2IgvzrZUDZ7Ls9ewonxegu0QfwgJo3dqA3rTgxED2n5cPI00QDfJOf5PQ7HiZFe+T4HzGFLaCFdLwkYycfeGfUSvbhRssiB2q5zOuYhVtrLDIAwd17k6IbpJ5AB9lWdagpJi+dPQJTzYIhZjl+6HPiifhaX5pb6ETMNSyIrIJIwHHSxf1hyfk6KfZknp5Qlrw03\/qQTqt+2rtvTV7CjGgXc6iyhRWCTjlJuyWSA1VPzKb0MeHk1eXiI558\/TsmJWQjprIou0HPBlWbl2rYbMOgbvbyedpbYovC2Yg5IyDm8tVOXlxTFOgnxCgI=","refresh_token":"MCcRLzpTOFvb26kzx2rvZbYpY6kJ1RgdTW7XdWoeTVfNqMGc1gOeHzY2I43cp04zvktAgd!0ryOXuw!RPAUqWy8yntWMuICY5vZC!lCTbnEcln8EnH8ILmgCnPx*fKoMzwp9r2RyEvKywZuNZuAYZ2LeEngz5jZqmQqiHSj38gwZc4aWOePmKKqOHnkGGKZHNwP2SYletg!9lWTmA0QwR8KJBI7hhrt*1fUS7Hdtk6AAJdVH2XtHL3fdK1RynMlASvO6vccW7O2wssp6h031aUyAKCElka2Z3bReARDUA9Pzp9mXHDd6hz6do3!m3zcezrydPHDwzkH02p*ADCppcoXloJAwbD!mXIKh7X0W!dg3ffSZhuRdctsVgtT9LbEB5KEkXcpBcKR6nfAKh5yLzSTusk1FkxClShuAaTi2eqZFvrMtbUqMbKPwiWLehv!Y9I*60DLfMmSciRDMRCv2skqhuXVzqS9e0X483*F1YH!lN","expires":1501691484}
JSON;
        self::$client->setAccessToken(json_decode($access_token, true));
    }

    public static function tearDownAfterClass()
    {
        // do sth after the last test
    }

    public function testCreateCalendar($name = null){
        if(empty($name)) $name = self::generateRandomResourceId();
        $res = self::$client->createCalendar(new CalendarVO($name));
        $id = $res->getId();
        $this->assertTrue(!empty($id));
        echo printf("new calendar id %s", $id).PHP_EOL;
        return $id;
    }

    public function testDeleteCalendar(){
        $id  = $this->testCreateCalendar();
        // https://stackoverflow.com/questions/31923669/office-365-unified-api-error-when-deleting-a-calendar
        // https://stackoverflow.com/questions/44597230/office365-calendar-rest-api-cannot-delete-calendars
        //self::$client->updateCalendar($id, new CalendarVO("deleted!"));
        $res = self::$client->deleteCalendar($id);

        $this->assertTrue($res);
    }

    public function testAddNewEvent(){
        $id  = $this->testCreateCalendar();

        $res = self::$client->createEvent($id, new EventVO(
            "test event",
            "test event body",
            new DateTime('2017-11-01 09:00:00'),
            new DateTime('2017-11-01 10:30:00'),
            new DateTimeZone('Australia/Sydney'),
            new LocationVO(
                "Boston Marriott Copley Place",
                new AddressVO(
                    "110 Huntington Av",
                    "Boston",
                    "MA",
                    "USA",
                    "02116"
                ),
                "42.3471832",
                "-71.0778024"
            )
        ));

        $this->assertTrue($res instanceof \OutlookRestClient\Facade\Responses\EventResponse);
        $this->assertTrue(!empty($res->getId()));

        return $res->getId();
    }

    public function testGetCalendars(){
        $res = self::$client->getCalendars();
        $this->assertTrue(count($res->getEntries()) > 0);
    }

    public function testDeleteNewEvent(){
        $id  = $this->testAddNewEvent();

        $res = self::$client->deleteEvent($id);

        $this->assertTrue($res);
    }
}