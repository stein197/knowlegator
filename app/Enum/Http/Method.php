<?php
namespace App\Enum\Http;

enum Method {

	case GET;
	case HEAD;
	case POST;
	case PUT;
	case PATCH;
	case DELETE;
	case OPTIONS;
}
