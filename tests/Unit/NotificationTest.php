<?php

namespace Tests\Unit;

use App\Http\Services\ChatServices\GetChatService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        //var_dump(app(GetChatService::class)->getChatIdList());
    }
}
