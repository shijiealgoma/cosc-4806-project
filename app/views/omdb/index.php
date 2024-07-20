<?php require_once 'app/views/templates/header.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Search Movie</h1>
            </div>
        </div>
    </div>
    <div class="main-content mt-3">
        <h2 class="main-title">Welcome to Movie Search</h2>
        <p>OMDB movie content search.</p>
        <!-- movie name input and search button -->
        <form action="/omdb/index" method="post">
            <div class="form-group">
                <label for="movieName">Movie Name</label>
                <input type="text" class="form-control" id="movieName" name="movieName" placeholder="Enter movie name">
            </div>    
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <?php if (isset($data['movie']) && !empty($data['movie'])) : ?>
        <div class="movie-result mt-5">
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
                <p><strong>Poster:</strong><br> <img src="<?php echo htmlspecialchars($data['movie']['Poster']); ?>" alt="Movie Poster"></p>
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
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12 mt-5">
            <p> <a href="/logout">Click here to logout</a></p>
        </div>
    </div>
</div>
<?php require_once 'app/views/templates/footer.php' ?>
