<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Models\Expense;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class AddExpenseTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        Add an expense to the database. It takes description and amount.
    MARKDOWN;

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'amount'      => 'required|numeric',
        ]);

        Expense::create($validated);

        logger($validated);

        return Response::text('Expense added successfully.');
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'description' => $schema->string()
                ->description('The description of the expense')
                ->required(),
            'amount' => $schema->number()
                ->description('The amount of the expense')
                ->required(),
        ];
    }
}
