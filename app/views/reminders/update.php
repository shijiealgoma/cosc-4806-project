<?php require_once 'app/views/templates/header.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Update Reminders</h1>
                <!-- link back to reminders -->
                <a href="/reminders/index" class="">Back to Reminders</a>
                <p class="lead"> <?= date("F jS, Y"); ?></p>
            </div>
        </div>
    </div>
    <div class="main-content mt-3">
        
      <!-- form with subject and submit -->
        <form action="/reminders/update_reminder/<?php echo $data['reminder']['id'] ?>" method="post">
            <div class="form-group">
                <label for="subject">Update Subject for Reminder id 
                    <?php echo $data['reminder']['id'];   ?> </label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject" value="<?php echo $data['reminder']['subject']; ?>"  >
            </div>
             <br/>
            <button type="submit" class="btn btn-primary">Update</button>

            
        </form>
        <br/>
        <p>For debug: <?php print_r($data['reminder']); ?></p>
        <p>For debug: <?php echo $data['reminder']['subject']; ?></p>
    </div>
</div>



<?php require_once 'app/views/templates/footer.php' ?>
