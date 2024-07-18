<?php require_once 'app/views/templates/header.php' ?>
<div class="container mb-5">
    <div class="page-header" id="banner">
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1>Admin Reports Page</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3>All reminders</h3>
            </div>
            <div class="col-lg-12">
                <div class="main-content mt-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Subject</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['reminders'] as $reminder): ?>
                                <tr>
                                    <td><?php echo $reminder['id']; ?></td>
                                    <td><?php echo $reminder['user_id']; ?></td>
                                    <td><?php echo $reminder['subject']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <h3>User who has the most reminders</h3>
            </div>
            <div class="col-lg-12">
                <div class="main-content mt-3">
                    <div>User ID: <?php echo  $data["most_id"]["user_id"]; ?></div>
                    <div>Username: <?php echo  $data["most_username"]['username']; ?></div>
                    <div>Reminders count: <?php echo $data["most_id"]["count"]; ?></div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <h3>How many total logins by username</h3>
                <div>Max Login: <?php echo $data['max_logins'] ?></div>
                
            </div>
            <div class="col-lg-12">
                <div class="main-content mt-3">

                    <table class="logins-table">
                        <tr>
                            <th>User</th>
                            <th>Total Logins</th>
                            <th>Chart</th>
                        </tr>
                        <?php foreach ($data["total_login"] as $login): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($login['user']); ?></td>
                                <td><?php echo htmlspecialchars($login['total_logins']); ?></td>
                                <th class="chat-th">
                                    <div class="bar" style="width: <?php echo ($login['total_logins'] / $data['max_logins']) * 100; ?>%">
                                        <?php echo htmlspecialchars($login['total_logins']); ?>
                                    </div>
                                </th>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <br /> <br /><br /><br /><br />
    </div>

    
</div>
<?php require_once 'app/views/templates/footer.php' ?>
