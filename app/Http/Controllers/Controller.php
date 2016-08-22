<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
	protected function deliver($content){
		return response($content)
			->withHeaders([
				'Cache-Control' => 'public',
				'Content-Type' => 'application/json',
				'Expires' => $this->get_next_saturday(),
				'Warning' => 'A few data inaccuracies may exist.'
			]);
	}

	public function get_next_saturday(){
		$date = new \DateTime();
		$date->modify('next Saturday');
		// DateTime formatted for Header, RFC1123 is the constant formatting
		return $date->format(\DateTime::RFC1123);
	}
}

