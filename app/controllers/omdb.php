<?php

class Omdb extends Controller {

    public function index() {
      $query_url =  "http://www.omdbapi.com/?i=tt3896198&apikey=".$_EVN['omdb_key'];
      $data = file_get_contents($query_url);
      $data = json_decode($data, true);
      $movie = (array) $data;

      echo "<pre>";
      print_r($movie);
      die;

      $this->view('home/index');
    }

}
