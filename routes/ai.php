<?php

use Laravel\Mcp\Facades\Mcp;    
use App\Mcp\Servers\ExpenseServer;

Mcp::web('/mcp/expense', ExpenseServer::class);
