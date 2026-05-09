<h1>Admin Dashboard</h1>

<a href="?url=logout">Logout</a>

<h3>Danh sách user</h3>

<table border="1">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
</tr>

<?php foreach($users as $u): ?>
<tr>
    <td><?= $u['id'] ?></td>
    <td><?= $u['fullname'] ?></td>
    <td><?= $u['email'] ?></td>
</tr>
<?php endforeach; ?>

</table>