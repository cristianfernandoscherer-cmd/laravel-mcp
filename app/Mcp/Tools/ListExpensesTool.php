<?php

declare(strict_types=1);

namespace App\Mcp\Tools;

use App\Models\Expense;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class ListExpensesTool extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = <<<'MARKDOWN'
        List all expenses from the database.
    MARKDOWN;

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Response
    {
        $expenses = Expense::all();

        return Response::text($expenses->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * The tool's schema.
     */
    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
