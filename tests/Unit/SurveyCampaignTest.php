<?php

namespace Tests\Unit;

use App\Models\SurveyCampaign;
use App\Models\SurveyCampaignPerson;
use App\Models\SurveyCampaignVariable;
use Tests\TestCase;

class SurveyCampaignTest extends TestCase
{
    /** @test */
    public function test_survey_campaign_variables() {
        $campaign = SurveyCampaign::factory()->create();
        SurveyCampaignVariable::factory()
            ->count(3)
            ->for($campaign)
            ->create();
        SurveyCampaignPerson::factory()
            ->count(3)
            ->for($campaign)
            ->create();

        $this->assertEquals($campaign->surveyCampaignVariables->count(), 3);
    }

    public function test_survey_campaign_persons() {
        $campaign = SurveyCampaign::factory()->create();
        SurveyCampaignVariable::factory()
            ->count(3)
            ->for($campaign)
            ->create();
        SurveyCampaignPerson::factory()
            ->count(3)
            ->for($campaign)
            ->create();

        $this->assertEquals($campaign->surveyCampaignPersons->count(), 3);
    }
}
