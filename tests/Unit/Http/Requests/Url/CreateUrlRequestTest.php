<?php

namespace Tests\Unit\Http\Requests\Url;

use PHPUnit\Framework\TestCase;

/**
 * @see \App\Http\Requests\Url\CreateUrlRequest
 */
class CreateUrlRequestTest extends TestCase
{
    /** @var \App\Http\Requests\Url\CreateUrlRequest */
    private $subject;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\Url\CreateUrlRequest();
    }

    /**
     * This method responsible of the request rules tests
     */
    public function testRequestRules(): void
    {
        $this->assertEquals([
            'url' => ['required', 'url'],
        ], $this->subject->rules());
    }

    /**
     * This method responsible of the request messages tests
     */
    public function testRequestMessages(): void
    {
        $this->assertEquals([], $this->subject->messages());
    }
}
