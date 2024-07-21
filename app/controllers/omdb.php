<?php

class Omdb extends Controller {

    public function index() {
        $movies = [];
        // if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
        //     $query_url = "http://www.omdbapi.com/?s=" . urlencode($_POST['search']) . "&apikey=" . $_ENV['omdb_key'];
        //     $data = file_get_contents($query_url);
        //     $data = json_decode($data, true);
        //     $movies = $data['Search'] ?? [];
        // }
        $this->view('omdb/index', ['movies' => $movies]);
    }

    // Search by title
    public function search($movieName){
        $movies = [];
        $rates = -1;
        $reviews = [];

        
 
        echo "Search by title";
        echo $movieName;
        // die;

      
        $query_url = "http://www.omdbapi.com/?t=" . $movieName . "&apikey=" . $_ENV['omdb_key'];

      
        $data = file_get_contents($query_url);

      
        $data = json_decode($data, true);
        $movies = (array) $data;

        echo "<br/>";
        echo "<h1>Search Results</h1>";
        print_r($movies);
        
        if (!empty($movies)) {
              // echo "<br/>";
              // echo "<h1>movies['Search']</h1>";
              // echo "<br/>";

                $titlename = $movies['Title'];

              echo "titlename: " . $titlename;
              echo "<br/>";

                $movieModel = $this->model('Movie');

                $movieName = urldecode($movieName);
              
                //getMovieIdByName
                $movieId = $movieModel->getMovieIdByName($titlename);
                
                echo "<br/>movieId: ". $movieId ;
                
              if ($movieId) {
                    $rates = $movieModel->getMovieRates($movieId);
                    $reviews = $movieModel->getMovieReviews($movieId);
                }
            
        }

        $this->view('omdb/index', ['movie' => $movies,
                    'movieId' => $movieId,
                    'movieTitle' => $titlename,
                    'rates' => $rates,
                    'reviews' => $reviews
                    ]);
    }

    // Add rating: title and rating
    public function addRate($movieTitle){
        $movieModel = $this->model('Movie');

        
        $movie_rating = $_POST['newRate'];
        $movie_title = urldecode($movieTitle);
        // echo "<br/>";
        // echo "movie_title: " . $movie_title;
        // echo "<br/>";
        // echo "movie_rating: " . $movie_rating;
      
        if ($movie_title && $movie_rating) {
            $movieId = $movieModel->getMovieIdByName($movie_title);
            // echo "<br/>";
            // echo "Movie ID: " . $movieId;
            if ($movieId) {
                // echo "<br/>";
                // echo "Has Movie ID!";
                $movieModel->addMovieRate($movieId, $movie_rating);
            } else {
                // echo "<br/>";
                // echo "NO Movie ID!";
                // Add movie if not exist
                $movieModel->addMovie($movie_title);
                $movieId = $movieModel->getMovieIdByName($movie_title);
                $movieModel->addMovieRate($movieId, $movie_rating);
            }
        }

        header('Location: /omdb/search/' . $movieTitle);
        exit();
    }

    // Add review: title and review
    public function addReview($movieTitle, ){
        $movieModel = $this->model('Movie');
        $movie_review = $_POST['newReview'];
        $movie_title = urldecode($movieTitle);
        // echo "<br/>";
        // echo "movie_title: " . $movie_title;
        // echo "<br/>";
        // echo "movie_review: " . $movie_review;
      
        if ($movie_title && $movie_review) {
            $movieId = $movieModel->getMovieIdByName($movie_title);
            if ($movieId) {
                $movieModel->addMovieReview($movieId, $movie_review);
            } else {
                // Add movie if not exist
                $movieModel->addMovie($movie_title);
                $movieId = $movieModel->getMovieIdByName($movie_title);
                $movieModel->addMovieReview($movieId, $movie_review);
            }
        }

        header('Location: /omdb/search/' . $movieTitle);
        exit();
    }
}
