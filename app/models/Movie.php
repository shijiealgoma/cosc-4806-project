<?php

class Movie {

    public $id;
    public $name;

    public function __construct() {

    }

    // Get all movies
    public function getAllMovies() {
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM movie;");
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    // Insert a new movie
    public function addMovie($name) {
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO movie (name) VALUES (:name);");
        $statement->bindValue(':name', $name);
        $statement->execute();
    }

    // Get movie rates and calculate the average
    public function getMovieRates($movie_id) {
        $db = db_connect();
        $statement = $db->prepare("SELECT rate FROM movie_rate WHERE movie_id = :movie_id;");
        $statement->bindValue(':movie_id', $movie_id, PDO::PARAM_INT);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        //echo "<pre>";
        //print_r($rows);
        if (count($rows) > 0) {
            $sum = 0;
            foreach ($rows as $row) {
                $sum += $row['rate'];
            }
            $average = $sum / count($rows);
        } else {
            $average = null; // No ratings available
        }

        return [
            'rates' => $rows,
            'average' => $average
        ];
    }

    // Get movie reviews
    public function getMovieReviews($movie_id) {
        $db = db_connect();
        $statement = $db->prepare("SELECT review FROM movie_review WHERE movie_id = :movie_id;");
        $statement->bindValue(':movie_id', $movie_id, PDO::PARAM_INT);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    // Add a movie rate
    public function addMovieRate($movie_id, $rate) {
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO movie_rate (movie_id, rate) VALUES (:movie_id, :rate);");
        $statement->bindValue(':movie_id', $movie_id, PDO::PARAM_INT);
        $statement->bindValue(':rate', $rate, PDO::PARAM_INT);
        $statement->execute();
    }

    // Add a movie review
    public function addMovieReview($movie_id, $review) {
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO movie_review (movie_id, review) VALUES (:movie_id, :review);");
        $statement->bindValue(':movie_id', $movie_id, PDO::PARAM_INT);
        $statement->bindValue(':review', $review);
        $statement->execute();
    }

    // Get movie details (including rates and reviews)
    public function getMovieDetails($movie_id) {
        $db = db_connect();

        // Get movie information
        $statement = $db->prepare("SELECT * FROM movie WHERE id = :movie_id;");
        $statement->bindValue(':movie_id', $movie_id, PDO::PARAM_INT);
        $statement->execute();
        $movie = $statement->fetch(PDO::FETCH_ASSOC);

        // Get rates
        $statement = $db->prepare("SELECT rate FROM movie_rate WHERE movie_id = :movie_id;");
        $statement->bindValue(':movie_id', $movie_id, PDO::PARAM_INT);
        $statement->execute();
        $rates = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Get reviews
        $statement = $db->prepare("SELECT review FROM movie_review WHERE movie_id = :movie_id;");
        $statement->bindValue(':movie_id', $movie_id, PDO::PARAM_INT);
        $statement->execute();
        $reviews = $statement->fetchAll(PDO::FETCH_ASSOC);

        return [
            'movie' => $movie,
            'rates' => $rates,
            'reviews' => $reviews
        ];
    }

    // Get movie ID by name
    public function getMovieIdByName($name) {
        echo "getMovieIdByName: " . $name;
        
        $db = db_connect();
        $statement = $db->prepare("SELECT id FROM movie WHERE name = :name;");
        $statement->bindValue(':name', $name);
        $statement->execute();
        $movie = $statement->fetch(PDO::FETCH_ASSOC);
        return $movie ? $movie['id'] : null;
    }
}
