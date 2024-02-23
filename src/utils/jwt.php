<?php

class JWT {

	static function Validar() {

		$headers = getallheaders();
		
        if (isset($headers['Authorization'])) {
		
			$token = str_replace("Bearer ", "", $headers['Authorization']);
			if(!JWT::ValidarJWT($token)){
				die(Flight::json(ArrestDB::$HTTP[401], 401));
			}

			$payload = JWT::GetData($token);
			if(isset($payload->usuario)){
				$usuario = $payload->usuario;
				session_start();
				$_SESSION['usuario'] = $usuario;
			}

		} else {
			die(Flight::json(ArrestDB::$HTTP[401], 401));
		}
	}

	static function Generar($usuario){
		$headers = array('alg'=>'HS256','typ'=>'JWT');
		$payload = array(
			'usuario'=> $usuario,
			'exp'=> (time() + 1 * 24 * 3600)
		);

		$headers_encoded = JWT::Base64UrlEncode(json_encode($headers));
	
		$payload_encoded = JWT::Base64UrlEncode(json_encode($payload));
		
		$signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", JWT::GetKey(), true);
		$signature_encoded = JWT::Base64UrlEncode($signature);
		
		$jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
		
		return $jwt;
	}

	static function Base64UrlEncode($str){
		return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
	}

	static function ValidarJWT($jwt){

		$tokenParts = explode('.', $jwt);
		$header = base64_decode($tokenParts[0]);
		$payload = base64_decode($tokenParts[1]);
		$signature_provided = $tokenParts[2];

		$expiration = json_decode($payload)->exp;
		$is_token_expired = ($expiration - time()) < 0;

		$base64_url_header = JWT::Base64UrlEncode($header);
		$base64_url_payload = JWT::Base64UrlEncode($payload);
		$signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, JWT::GetKey(), true);
		$base64_url_signature = JWT::Base64UrlEncode($signature);

		$is_signature_valid = ($base64_url_signature === $signature_provided);
		
		if ($is_token_expired || !$is_signature_valid) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	static function GetData($jwt){
		$tokenParts = explode('.', $jwt);
		$header = base64_decode($tokenParts[0]);
		$payload = base64_decode($tokenParts[1]);
		$signature_provided = $tokenParts[2];

		$expiration = json_decode($payload)->exp;
		$is_token_expired = ($expiration - time()) < 0;

		$base64_url_header = JWT::Base64UrlEncode($header);
		$base64_url_payload = JWT::Base64UrlEncode($payload);
		$signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, JWT::GetKey(), true);
		$base64_url_signature = JWT::Base64UrlEncode($signature);

		$is_signature_valid = ($base64_url_signature === $signature_provided);
		
		if ($is_token_expired || !$is_signature_valid) {
			return null;
		} else {
			return json_decode($payload);
		}
	}

	static private function GetKey(){
		$env = DB::getEnvironment();
		return $env['APP_KEY'];
	}
}