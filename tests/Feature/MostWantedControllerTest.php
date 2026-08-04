<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\DTO\WantedPersonDTO;
use App\Interfaces\WantedRepositoryInterface;

class MostWantedControllerTest extends TestCase
{

    public $base_version = '/api/v1';


    /**
     * Assert successful fetching of most wanted data
     * @return void
     */
    public function testGetMostWantedData()
    {
        $response = $this->getJson('/api/wanted');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'error',
                'message',
                'data' => [['title', 'description', 'reward_text']]
            ]);
    }

    /**
     * ✅ Test fetching most wanted individuals with filters (e.g., nationality)
     */
    public function test_fetch_most_wanted_with_filters()
    {
        $fakeData = [
            WantedPersonDTO::fromArray([
                'title' => 'JOHN DOE',
                'description' => 'Test suspect',
                'reward_text' => null,
                'nationality' => 'American',
                'status' => 'na',
            ]),
        ];

        $this->mock(WantedRepositoryInterface::class, function ($mock) use ($fakeData) {
            $mock->shouldReceive('fetchList')
                ->once()
                ->with(['nationality' => 'American'])
                ->andReturn($fakeData);
        });

        $filters = ['nationality' => 'American'];
        $response = $this->getJson('/api/wanted?' . http_build_query($filters));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'error',
                'message',
                'data' => [['title', 'nationality']]
            ])
            ->assertJsonFragment([
                'nationality' => 'American'
            ]);
    }
}
