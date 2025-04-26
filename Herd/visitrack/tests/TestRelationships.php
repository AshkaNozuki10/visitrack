<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\TblAddress;
use App\Models\TblInformation;
use Tests\TestCase;

class TestRelationships extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_address()
    {
        $address = TblAddress::factory()->create();
        $info =  TblInformation::factory()->create(['address' => $address->address_id]);
    }
}
