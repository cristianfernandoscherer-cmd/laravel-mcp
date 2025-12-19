<?php

declare(strict_types=1);

namespace App\Mcp\Servers;

use App\Mcp\Tools\AddExpenseTool;
use App\Mcp\Tools\ListExpensesTool;
use Laravel\Mcp\Server;

class ExpenseServer extends Server
{
    /**
     * The MCP server's name.
     */
    protected string $name = 'Expense Server';

    /**
     * The MCP server's version.
     */
    protected string $version = '0.0.1';

    /**
     * The MCP server's instructions for the LLM.
     */
    protected string $instructions = <<<'MARKDOWN'
        This server is used to manage expenses. We can use the tool to add expenses and get the total expenses.
    MARKDOWN;

    /**
     * The tools registered with this MCP server.
     *
     * @var array<int, class-string<Server\Tool>>
     */
    protected array $tools = [
        AddExpenseTool::class,
        ListExpensesTool::class,
    ];

    /**
     * The resources registered with this MCP server.
     *
     * @var array<int, class-string<Server\Resource>>
     */
    protected array $resources = [
        //
    ];

    /**
     * The prompts registered with this MCP server.
     *
     * @var array<int, class-string<Server\Prompt>>
     */
    protected array $prompts = [
        //
    ];
}
