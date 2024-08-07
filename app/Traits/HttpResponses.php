<?php

namespace App\Traits;

trait HttpResponses{
	protected function success($data, $message = null, $code = 200){
		return response()->json([
			'status' => true,
			'message' => $message,
			'data' => $data
		], $code);
	}

	protected function error($data, $code = 500, $message = null){
		return response()->json([
			'status' => false,
			'message' => $message,
			'data' => $data
		], $code);
	}
}
