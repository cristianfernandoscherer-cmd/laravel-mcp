<?php

declare(strict_types=1);

namespace Tests\Unit\Mcp\Tools;

use App\Mcp\Tools\AddExpenseTool;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Mcp\Request;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddExpenseToolTest extends TestCase
{
    use RefreshDatabase;

    private function createRequest(array $params): Request
    {
        return new Request($params);
    }

    #[Test]
    public function it_can_add_an_expense_with_valid_data()
    {
        // Arrange
        $tool    = new AddExpenseTool;
        $request = $this->createRequest([
            'description' => 'Office supplies',
            'amount'      => 150.50,
        ]);

        // Act
        $response = $tool->handle($request);

        // Assert
        $this->assertDatabaseHas('expenses', [
            'description' => 'Office supplies',
            'amount'      => 150.50,
        ]);

        // Verify response is a Response object
        $this->assertInstanceOf(\Laravel\Mcp\Response::class, $response);
    }

    #[Test]
    public function it_validates_required_description()
    {
        // Arrange
        $tool    = new AddExpenseTool;
        $request = $this->createRequest([
            'amount' => 100,
        ]);

        // Act & Assert
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $tool->handle($request);
    }

    #[Test]
    public function it_validates_required_amount()
    {
        // Arrange
        $tool    = new AddExpenseTool;
        $request = $this->createRequest([
            'description' => 'Test expense',
        ]);

        // Act & Assert
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $tool->handle($request);
    }

    #[Test]
    public function it_validates_amount_is_numeric()
    {
        // Arrange
        $tool    = new AddExpenseTool;
        $request = $this->createRequest([
            'description' => 'Test expense',
            'amount'      => 'not-a-number',
        ]);

        // Act & Assert
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $tool->handle($request);
    }

    #[Test]
    public function it_can_add_expense_with_decimal_amount()
    {
        // Arrange
        $tool    = new AddExpenseTool;
        $request = $this->createRequest([
            'description' => 'Coffee',
            'amount'      => 4.99,
        ]);

        // Act
        $tool->handle($request);

        // Assert
        $this->assertDatabaseHas('expenses', [
            'description' => 'Coffee',
            'amount'      => 4.99,
        ]);
    }

    #[Test]
    public function it_can_add_expense_with_zero_amount()
    {
        // Arrange
        $tool    = new AddExpenseTool;
        $request = $this->createRequest([
            'description' => 'Free item',
            'amount'      => 0,
        ]);

        // Act
        $tool->handle($request);

        // Assert
        $this->assertDatabaseHas('expenses', [
            'description' => 'Free item',
            'amount'      => 0,
        ]);
    }

    #[Test]
    public function it_can_add_expense_with_negative_amount()
    {
        // Arrange
        $tool    = new AddExpenseTool;
        $request = $this->createRequest([
            'description' => 'Refund',
            'amount'      => -50.00,
        ]);

        // Act
        $tool->handle($request);

        // Assert
        $this->assertDatabaseHas('expenses', [
            'description' => 'Refund',
            'amount'      => -50.00,
        ]);
    }

    #[Test]
    public function it_creates_expense_with_current_date_if_not_provided()
    {
        // Arrange
        $tool    = new AddExpenseTool;
        $request = $this->createRequest([
            'description' => 'Test',
            'amount'      => 100,
        ]);

        // Act
        $tool->handle($request);

        // Assert
        $this->assertEquals(1, Expense::count());
        $expense = Expense::first();
        $this->assertNotNull($expense->created_at);
    }
}
