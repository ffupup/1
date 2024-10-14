<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>


<!-- TEST TO DISPLAY IF THEY GOT ADDED TO THE DATABASE. obviously the final product would not show everyone's usernames and passwords, might be for admins only if time-->
<h1>Home page</h1>
<!--script src="scripts.js"></script--><!--This is not being used currently, it is just a placeholder in case there is any js or other thing to be called, we can change it later as required-->
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>User Type</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['password'] ?></td>
                <td><?= $user['user_type'] ?>
                <a href="<?= base_url('users/delete/' . $user['id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this User?')">Delete User</a></td>
            </tr>
            <?php endforeach; ?>
    </tbody>
</table>


<?= $this->endSection() ?>