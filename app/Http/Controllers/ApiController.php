<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{

	// Charts ---------------------------------------------//
	
	public function charts($date, Request $req){
		// Create a combined WHERE statement to filter SELECT results
		$where_clause = $this->digest_query_string([['date', '=', $date]], $req);

		// Determine whether the request is for albums, songs, or both
		if($req['filter'] === 'album'){
			$res = $this->get_chart('album', $req, $where_clause);
		} elseif($req['filter'] === 'song') {
			$res = $this->get_chart('song', $req, $where_clause);
		} else {
			// If the requests asks for both resources, then present them as two separate arrays
			$res = array(
				'albums' => $this->get_chart('album', $req, $where_clause),
				'songs' => $this->get_chart('song', $req, $where_clause)
			);
		}

		return parent::deliver($res);
	}

	private function get_chart($cat, $req, $where){
		// Check whether the request is pithy
		if(isset($req['pithy']) && $req['pithy']){
			// If pithy, only return rank and id number
			$query = DB::table("chart_$cat")
				->select('rank', "{$cat}_key");
		} else {
			// Otherwise, return all information related to the album/song
			$query = DB::table("chart_$cat")
				->select("chart_{$cat}.rank", "{$cat}.*")
				->join($cat, "{$cat}_key", '=', "{$cat}_id");
		}
		
		// Actually query the query, order by rank, and return the results
		return $query->where($where)
			->orderBy('rank', 'asc')->get();
	}

	// Ranking --------------------------------------------//
	
	public function ranking($filter, $num, Request $req){
		// Create a combined WHERE statement to filter SELECT results
		$where_clause = $this->digest_query_string([['rank', '=', $num]], $req);

		// Determine whether the request is for albums or songs
		if($filter === 'album'){
			$res = $this->get_rank('album', $req, $where_clause);
		} elseif($filter === 'song') {
			$res = $this->get_rank('song', $req, $where_clause);
		} else {
			
		}

		return parent::deliver($res);
	}

	private function get_rank($cat, $req, $where){
		// Check whether the request is pithy
		if(isset($req['pithy']) && $req['pithy']){
			// If pithy, only return date and id number
			$query = DB::table("chart_$cat")
				->select(DB::raw("date(date) AS date"), "{$cat}_key");
		} else {
			// Otherwise, return all information related to the album/song
			$query = DB::table("chart_$cat")
				->select(DB::raw("DATE(chart_{$cat}.date) AS date"), "{$cat}.*")
				->join($cat, "{$cat}_key", '=', "{$cat}_id");
		}
		
		// Actually query the query, order by date, and return the results
		return $query->where($where)
			->orderBy('date', 'desc')->get();
	}

	// Artist ---------------------------------------------//
	
	public function artist($id, Request $req){
		// Create a combined WHERE statement to filter SELECT results
		$where_clause = $this->digest_query_string([['artist_id', '=', $id]], $req);

		// Create initial result array with Artist name
		$res = array(
			'name' => DB::table('artist')
				->select('artist_name')
				->where('artist_id', $id)
				->first()->artist_name
		);

		// Determine whether the request is for albums, songs, or both
		if($req['filter'] === 'album'){
			$res['albums'] = $this->get_artist('album', $req, $where_clause);
		} elseif($req['filter'] === 'song') {
			$res['songs'] = $this->get_artist('song', $req, $where_clause);
		} else {
			// If the requests asks for both resources, then present them as two separate arrays
			$res['albums'] = $this->get_artist('album', $req, $where_clause);
			$res['songs'] =	$this->get_artist('song', $req, $where_clause);
		}

		return parent::deliver($res);
	}

	private function get_artist($cat, $req, $where){
		// Check whether the request is pithy
		if(isset($req['pithy']) && $req['pithy']){
			// If pithy, only return rank and album/song info
			$query = DB::table("$cat")
				->select(
					"{$cat}_id",
					"{$cat}_name",
					"spotify_id"
				);
		} else {
			// Otherwise, return highest_rank and weeks_on_chart
			$query = DB::table("$cat")
				->select(
					"{$cat}_id",
					"{$cat}_name",
					"spotify_id",
					DB::raw("MIN(rank) AS highest_rank"),
					DB::raw("COUNT(rank) AS weeks_on_chart")
				)
				->join("chart_$cat", "{$cat}_key", '=', "{$cat}_id")
				->groupBy("{$cat}_name");
		}
		
		// Actually query the query, order by rank, and return the results
		return $query->where($where)
			->orderBy("{$cat}_name", 'asc')->get();
	}

	// Album / Song ---------------------------------------//

	public function music($filter, $id, Request $req){
		// Create a combined WHERE statement to filter SELECT results
		$where_clause = $this->digest_query_string([["{$filter}_key", '=', $id]], $req);

		// Create initial result array with Album or Song info
		$res = array(
			"{$filter}" => DB::table("{$filter}")
				->where("{$filter}_id", $id)
				->first()
		);

		// Determine whether the request is for albums or songs
		if($filter === 'album'){
			$res['rankings'] = $this->get_music('album', $where_clause);
		} elseif($filter === 'song') {
			$res['rankings'] = $this->get_music('song', $where_clause);
		}

		return parent::deliver($res);
	}

	private function get_music($cat, $where){
		$query = DB::table("chart_$cat")
			->select(DB::raw("DATE(date) AS date"), 'rank');
		
		// Actually query the query, order by date, and return the results
		return $query->where($where)
			->orderBy('date', 'asc')->get();
	}

	// Search ---------------------------------------------//
	
	public function search($table, Request $req){
		// Determine if the search is going to be an exact search
		if(isset($req['exact']) && $req['exact']){
			$query_term = $req['q'];
		} else {
			$query_term = "%{$req['q']}%";
		}

		$res = DB::table("{$table}")
			// Make the search case insensitive with UTF8_GENERAL_CI
			->where(DB::raw("{$table}_name COLLATE UTF8_GENERAL_CI"), 'like', $query_term)
			->get();

		return parent::deliver($res);
	}


	/*
	|------------------------------------------------
	| Helpers
	|------------------------------------------------
	*/

	protected function digest_query_string($where, $req){
		$query_strings = $req->all();
		
		foreach($query_strings as $key => $value){
			switch($key){
				case 'min':
					array_push($where, ['rank', '>=', $value]);
					break;
				case 'max':
					array_push($where, ['rank', '<=', $value]);
					break;
				case 'from':
					array_push($where, ['date', '>=', $value]);
					break;
				case 'to':
					array_push($where, ['date', '<=', $value]);
					break;
			}
		}

		return $where;
	}

}