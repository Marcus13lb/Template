<?php

class ArrestDB
{
	public static $HTTP = [
		200 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 200,
				'status' => 'OK',
			],
			'meta' => null
		],
		201 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 201,
				'status' => 'Created',
			],
			'meta' => null
		],
		204 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 204,
				'status' => 'No Content',
			],
			'meta' => null
		],
		400 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 400,
				'status' => 'Bad Request',
			],
			'meta' => null
		],
		401 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 401,
				'status' => 'Unauthorized',
			],
			'meta' => null
		],
		403 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 403,
				'status' => 'Forbidden',
			],
			'meta' => null
		],
		404 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 404,
				'status' => 'Not Found',
			],
			'meta' => null
		],
		406 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 406,
				'status' => 'Not Acceptable',
			],
			'meta' => null
		],
		409 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 409,
				'status' => 'Conflict',
			],
			'meta' => null
		],
		500 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 500,
				'status' => 'Internal Server Error',
			],
			'meta' => null
		],
		503 => [
            'result' => null,
			'message' => null,
			'http' => [
				'code' => 503,
				'status' => 'Service Unavailable',
			],
			'meta' => null
		],
	];
	
}