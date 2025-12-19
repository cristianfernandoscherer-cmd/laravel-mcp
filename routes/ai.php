<?php

declare(strict_types=1);

use App\Mcp\Servers\ExpenseServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/expense', ExpenseServer::class);
