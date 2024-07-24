<?php

namespace LunarisForge\Http\Enums;

enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
    case OPTIONS = 'OPTIONS';
    case PUT = 'PUT';
    case HEAD = 'HEAD';
    case TRACE = 'TRACE';
}
