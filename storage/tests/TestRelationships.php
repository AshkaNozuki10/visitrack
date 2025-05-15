<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Address;
use App\Models\User;
use Tests\TestCase;

class TestRelationships extends TestCase
{
    //Test the user address
    public function test_user_address()
    {
        $address = Address::factory()->create();
        $user =  User::factory()->create(['address' => $address->address_id]);

        $this->assertInstanceOf(Address::class, $user->address);
        //$this->assertEquals($address->id, $info->address->id);
    }
    
}
