<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{

    use WithoutMiddleware;
    use RefreshDatabase;

    public function test_permission_list()
    {
        $response=$this->getJson('/api/permission_list');
        $response->assertStatus(200);
        $response->assertJson(['success'=>true]);
    }

    public function test_permission_save()
    {
        $data = ['name'=>'jing.min','display_name' =>"管理员", 'description' =>'管理员'];
        $response=$this->postJson('/api/permission_save',$data);

        $response->assertStatus(200);
        $response->assertJson(['success'=>true]);

        $data = ['name'=>'jing.min','display_name' =>"管1理员11", 'description' =>'管理11员'];
        $response=$this->postJson('/api/permission_save',$data);
        $response->assertStatus(422);
    }


}