<?php

class Omdb extends Controller {

    public function index() {

      $movie = null;

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movieName'])) {
          $query_url = "http://www.omdbapi.com/?t=" . urlencode($_POST['movieName']) . "&apikey=" . $_ENV['omdb_key'];

          $data = file_get_contents($query_url);
          $data = json_decode($data, true);
          $movie = (array) $data;
      }

      // echo "<pre>";
      // print_r($movie);
      // die;


      $this->view('omdb/index', ['movie' => $movie]);
    }

    

}
