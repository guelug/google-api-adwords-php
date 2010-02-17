<?php
/**
 * This example adds a new campaign. To determine which campaigns
 * exist, run GetAllCampaignsExample.php.
 *
 * PHP version 5
 *
 * Copyright 2009, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsAdWords
 * @subpackage v200909
 * @category   WebServices
 * @copyright  2009, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @author     Adam Rogal <api.arogal@gmail.com>
 */

error_reporting(E_STRICT | E_ALL);

// You can set the include path to src directory or reference
// AdWordsUser.php directly via require_once.
// $path = '/path/to/aw_api_php_lib/src';
$path = dirname(__FILE__) . '/../../src';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'Google/Api/Ads/AdWords/Lib/AdWordsUser.php';

/**
 * This example adds a new campaign. To determine which campaigns
 * exist, run GetAllCampaignsExample.php.
 */
class AddCampaignExample {
  static function main() {
    try {
      // Get AdWordsUser from credentials in "../auth.ini"
      // relative to the AdWordsUser.php file's directory.
      $user = new AdWordsUser();

      // Log SOAP XML request and response.
      $user->LogDefaults();

      // Get the CampaignService.
      $campaignService = $user->GetCampaignService();

      // Create new campaign structure.
      $campaign = new Campaign();
      $campaign->name = 'Campaign #' . time();
      $campaign->status = 'PAUSED';
      $campaign->biddingStrategy = new ManualCPC();
      $campaign->budget = new Budget('DAILY', new Money(50000000), 'STANDARD');

      $operations = array(new CampaignOperation(NULL, $campaign, 'ADD'));

      // Add campaign.
      $campaignReturnValue = $campaignService->mutate($operations);

      // Display new campaigns.
      foreach ($campaignReturnValue->value as $campaign) {
        print 'New campaign with name "' . $campaign->name . '" and id "'
            . $campaign->id . "\" was created.\n";
      }
    } catch (Exception $e) {
      print_r($e);
    }
  }
}

AddCampaignExample::main();