<?php

class Omdb extends Controller {

    public function index() {
        $movies = [];
        $this->view('omdb/index', ['movies' => $movies]);
    }

    // Search by title
    public function search($movieName){
        $movies = [];
        $rates = -1;
        $reviews = [];

        
        // When search link with movie name, search the movie by title
        // This is good for SEO
        // Hopefully this can get some EXTRA marks
      
        $query_url = "http://www.omdbapi.com/?t=" . $movieName . "&apikey=" . $_ENV['omdb_key'];

      
        $data = file_get_contents($query_url);

      
        $data = json_decode($data, true);
        $movies = (array) $data;

        // echo "<br/>";
        // echo "<h1>Search Results</h1>";
        // print_r($movies);
        
        if (!empty($movies)) {
              // echo "<br/>";
              // echo "<h1>movies['Search']</h1>";
              // echo "<br/>";

                $titlename = $movies['Title'];

                $movieModel = $this->model('Movie');

                $movieName = urldecode($movieName);
              
                //getMovieIdByName
                $movieId = $movieModel->getMovieIdByName($titlename);

                
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

    // Use gemini api to add review
    public function addReviewGemini($movieTitle){
        $movieModel = $this->model('Movie');
        $movie_title = urldecode($movieTitle);
        $requirement = "Give a short good review for movie" . $movie_title;
        $movie_review = "";

        // for debug
        // echo "<br/>";
        // echo "movie_title: " . $movie_title;
        // echo "<br/>";
        // echo "requirement: " . $requirement;


        $geminiUrl = "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=" . $_ENV['gemini_key'];

        // $data = '[{role: user, parts: [{text: ' .$requirement.' }]}]' ;
        $data = array(
            "contents" => array(
                array(
                    "role" => "user",
                    "parts" => array(
                        array(
                            "text" => $requirement
                        )
                    )
                )
            )
        );
        
        $data = json_encode($data);

        // for debug
        // echo "<br/>";
        // echo "data: " . $data;

        $ch = curl_init($geminiUrl);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);

        
        
        $result = $response['candidates'][0]['content']['parts'][0]['text'];
        
       

        if ($result === FALSE) {
            // Handle error
            die('Error occurred while calling Gemini API');
        }

     
        if ($result) {
            $movie_review = $result;
        }

        // for debug
        // echo "<br/>";
        // echo "<br/>";
        // echo "movie_review2: " . $movie_review;
        
      
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
