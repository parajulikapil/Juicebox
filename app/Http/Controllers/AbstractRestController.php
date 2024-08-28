<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ErrorTrait;

abstract class AbstractRestController extends Controller
{
    use ErrorTrait;

    /**
     * Constructor
     */
    public function __construct(protected Request $request) {}    
}