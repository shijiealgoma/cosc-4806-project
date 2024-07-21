<?php require_once 'app/views/templates/header.php' ?>
<div class="container mb-5">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Welcome to Movie Search</h1>
            </div>
        </div>
    </div>
    <div class="main-content mt-3">
        <p>Popular Search: 
            <a href="/omdb/search/Barbie">Barbie</a>
            <a href="/omdb/search/Bear">Bear</a>
            <a href="/omdb/search/The+Pianist">The Pianist</a>
        </p>
        <!-- movie name input and search button -->
        <form id="searchForm" method="post">
            <div class="form-group">
                <label for="movieName">Movie Name</label>
                <input type="text" class="form-control" id="movieName" name="movieName" placeholder="Enter movie name">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <?php if (isset($data['movie']) && !empty($data['movie'])) : ?>
        <div class="row mt-5">
            <div class="col-md-12">
                <p><strong>Poster:</strong><br> <img src="<?php echo htmlspecialchars($data['movie']['Poster']); ?>" alt="Movie Poster"></p>
            </div>
            <div class="col-md-6">
                <div class="movie-result">
                    <h2>Search Result</h2>
                    <div class="movie-details">
                        <h3><?php echo htmlspecialchars($data['movie']['Title']); ?></h3>
                        <p><strong>Year:</strong> <?php echo htmlspecialchars($data['movie']['Year']); ?></p>
                        <p><strong>Rated:</strong> <?php echo htmlspecialchars($data['movie']['Rated']); ?></p>
                        <p><strong>Released:</strong> <?php echo htmlspecialchars($data['movie']['Released']); ?></p>
                        <p><strong>Runtime:</strong> <?php echo htmlspecialchars($data['movie']['Runtime']); ?></p>
                        <p><strong>Genre:</strong> <?php echo htmlspecialchars($data['movie']['Genre']); ?></p>
                        <p><strong>Director:</strong> <?php echo htmlspecialchars($data['movie']['Director']); ?></p>
                        <p><strong>Writer:</strong> <?php echo htmlspecialchars($data['movie']['Writer']); ?></p>
                        <p><strong>Actors:</strong> <?php echo htmlspecialchars($data['movie']['Actors']); ?></p>
                        <p><strong>Plot:</strong> <?php echo htmlspecialchars($data['movie']['Plot']); ?></p>
                        <p><strong>Language:</strong> <?php echo htmlspecialchars($data['movie']['Language']); ?></p>
                        <p><strong>Country:</strong> <?php echo htmlspecialchars($data['movie']['Country']); ?></p>
                        <p><strong>Awards:</strong> <?php echo htmlspecialchars($data['movie']['Awards']); ?></p>
                        
                        <p><strong>Box Office:</strong> <?php echo htmlspecialchars($data['movie']['BoxOffice']); ?></p>
                        <p><strong>IMDB Rating:</strong> <?php echo htmlspecialchars($data['movie']['imdbRating']); ?></p>
                        <p><strong>IMDB Votes:</strong> <?php echo htmlspecialchars($data['movie']['imdbVotes']); ?></p>
                        <p><strong>Metascore:</strong> <?php echo htmlspecialchars($data['movie']['Metascore']); ?></p>
                        <p><strong>Type:</strong> <?php echo htmlspecialchars($data['movie']['Type']); ?></p>
                        <p><strong>DVD Release:</strong> <?php echo htmlspecialchars($data['movie']['DVD']); ?></p>
                        <p><strong>Production:</strong> <?php echo htmlspecialchars($data['movie']['Production']); ?></p>
                        <p><strong>Website:</strong> <a href="<?php echo htmlspecialchars($data['movie']['Website']); ?>"><?php echo htmlspecialchars($data['movie']['Website']); ?></a></p>
                        <h3>Ratings</h3>
                        <?php if (!empty($data['movie']['Ratings'])): ?>
                            <ul>
                                <?php foreach ($data['movie']['Ratings'] as $rating): ?>
                                    <li><strong><?php echo htmlspecialchars($rating['Source']); ?>:</strong> <?php echo htmlspecialchars($rating['Value']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No ratings available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3>Rating</h3>
                <?php if (isset($data['rates']) && $data['rates'] !== -1): ?>              
                <!-- forloop $data['rates']['average'] -->
                <div>
                    <?php for( $i = 0; $i < $data['rates']['average']; $i++ ) : ?>
                        <span class="yellow">★</span>
                    <?php endfor; ?>
                     <span><?php echo " ".$data['rates']['average'] . " STARS"; ?></span>
                </div>
                        
               
                <?php else: ?>
                    <p>No ratings available.</p>
                <?php endif; ?>

                  <form action="/omdb/addRate/<?php echo urlencode($data['movie']['Title']); ?>" method="post">
                    <div class="form-group">
                        <label for="newRate">Add New Rating</label><br>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="newRate" id="rate<?php echo $i; ?>" value="<?php echo $i; ?>">
                                <label class="form-check-label" for="rate<?php echo $i; ?>"><?php echo $i; ?></label>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="movieTitle" value="<?php echo htmlspecialchars($data['movie']['Title']); ?>">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <h3>Reviews</h3>
                <?php if (isset($data['reviews']) && !empty($data['reviews'])): ?>
                    <div class=" ">
                        <?php foreach ($data['reviews'] as $review): ?>
                            <div class="card p-1 my-3  bg-white rounded box-shadow">
                                <b>User Review</b>
                                <?php echo htmlspecialchars($review['review']); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No reviews available.</p>
                <?php endif; ?>

                <form action="/omdb/addReview/<?php echo urlencode($data['movie']['Title']); ?>" method="post">
                    <div class="form-group">
                        <label for="newReview">Add New Review</label>
                        <textarea class="form-control" id="newReview" name="newReview" placeholder="Enter review"></textarea>
                    </div>
                    <input type="hidden" name="movieTitle" value="<?php echo htmlspecialchars($data['movie']['Title']); ?>">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12 mt-5">
            <p> <a href="/logout">Click here to logout</a></p>
        </div>
    </div>
</div>
<br /><br /><br /><br /><br />
<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var movieName = document.getElementById('movieName').value;
        this.action = '/omdb/search/' + encodeURIComponent(movieName);
        this.submit();
    });
</script>
<?php require_once 'app/views/templates/footer.php' ?>
