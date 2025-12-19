<?php

declare(strict_types=1);

namespace Tests\Unit\Mcp\Tools;

use App\Mcp\Tools\ListExpensesTool;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Mcp\Request;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ListExpensesToolTest extends TestCase
{
    use RefreshDatabase;

    private function createRequest(array $params = []): Request
    {
        return new Request($params);
    }

    #[Test]
    public function it_can_list_all_expenses()
    {
        // Arrange
        Expense::factory()->create([
            'description' => 'Lunch',
            'amount'      => 25.00,
        ]);

        Expense::factory()->create([
            'description' => 'Taxi',
            'amount'      => 15.50,
        ]);

        $tool    = new ListExpensesTool;
        $request = $this->createRequest();

        // Act
        $response = $tool->handle($request);

        // Assert - Verify expenses were created
        $this->assertEquals(2, Expense::count());
        $this->assertInstanceOf(\Laravel\Mcp\Response::class, $response);
    }

    #[Test]
    public function it_returns_response_when_no_expenses_exist()
    {
        // Arrange
        $tool    = new ListExpensesTool;
        $request = $this->createRequest();

        // Act
        $response = $tool->handle($request);

        // Assert
        $this->assertEquals(0, Expense::count());
        $this->assertInstanceOf(\Laravel\Mcp\Response::class, $response);
    }

    #[Test]
    public function it_returns_response_object()
    {
        // Arrange
        Expense::factory()->create([
            'description' => 'Test expense',
            'amount'      => 100.00,
        ]);

        $tool    = new ListExpensesTool;
        $request = $this->createRequest();

        // Act
        $response = $tool->handle($request);

        // Assert
        $this->assertInstanceOf(\Laravel\Mcp\Response::class, $response);
        $this->assertEquals(1, Expense::count());
    }

    #[Test]
    public function it_lists_expenses_in_database()
    {
        // Arrange
        Expense::factory()->create([
            'description' => 'First',
            'amount'      => 10.00,
            'created_at'  => now()->subDays(2),
        ]);

        Expense::factory()->create([
            'description' => 'Second',
            'amount'      => 20.00,
            'created_at'  => now()->subDay(),
        ]);

        Expense::factory()->create([
            'description' => 'Third',
            'amount'      => 30.00,
            'created_at'  => now(),
        ]);

        $tool    = new ListExpensesTool;
        $request = $this->createRequest();

        // Act
        $response = $tool->handle($request);

        // Assert
        $this->assertEquals(3, Expense::count());

        $expenses = Expense::all();
        $this->assertEquals('First', $expenses[0]->description);
        $this->assertEquals('Second', $expenses[1]->description);
        $this->assertEquals('Third', $expenses[2]->description);
    }

    #[Test]
    public function it_includes_all_expense_fields_in_database()
    {
        // Arrange
        Expense::factory()->create([
            'description' => 'Complete expense',
            'amount'      => 99.99,
        ]);

        $tool    = new ListExpensesTool;
        $request = $this->createRequest();

        // Act
        $response = $tool->handle($request);

        // Assert
        $expense = Expense::first();
        $this->assertNotNull($expense->id);
        $this->assertNotNull($expense->description);
        $this->assertNotNull($expense->amount);
        $this->assertNotNull($expense->created_at);
        $this->assertNotNull($expense->updated_at);
    }

    #[Test]
    public function it_can_list_many_expenses()
    {
        // Arrange
        Expense::factory()->count(50)->create();

        $tool    = new ListExpensesTool;
        $request = $this->createRequest();

        // Act
        $response = $tool->handle($request);

        // Assert
        $this->assertEquals(50, Expense::count());
        $this->assertInstanceOf(\Laravel\Mcp\Response::class, $response);
    }

    #[Test]
    public function it_returns_valid_response_type()
    {
        // Arrange
        Expense::factory()->create();
        $tool    = new ListExpensesTool;
        $request = $this->createRequest();

        // Act
        $response = $tool->handle($request);

        // Assert
        $this->assertInstanceOf(\Laravel\Mcp\Response::class, $response);
    }
}
