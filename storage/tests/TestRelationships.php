<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\TblAddress;
use App\Models\TblInformation;
use Tests\TestCase;

class TestRelationships extends TestCase
{
    //Test the user address
    public function test_user_address()
    {
        $address = TblAddress::factory()->create();
        $info =  TblInformation::factory()->create(['address' => $address->address_id]);

        $this->assertInstanceOf(TblAddress::class, $info->address);
        //$this->assertEquals($address->id, $info->address->id);
    }
    
}
