<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

trait LoggerService
{
	public function error(string $message, Exception $exception): array
	{
		$message = $exception->getMessage();
		$context = [
			'detail' => $exception->getMessage(),
			'file' => $exception->getFile(),
			'line' => $exception->getLine(),
		];

		Log::error($message, $context);

		return $context;
	}
}
