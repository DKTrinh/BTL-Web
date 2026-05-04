<?php require_once "../app/helpers/PaginationHelper.php"; ?>

<h2>User Management</h2>

<table border="1" cellpadding="10">
<tr>
<th>ID</th>
<th>Username</th>
<th>Email</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php foreach($users as $u): ?>
<tr>
<td><?= $u['id'] ?></td>
<td><?= $u['username'] ?></td>
<td><?= $u['email'] ?></td>

<td><?= $u['status'] ? 'Active' : 'Locked' ?></td>

<td>
<a href="public_entry.php?url=user-edit&id=<?= $u['id'] ?>">Edit</a>

<a href="public_entry.php?url=user-lock&id=<?= $u['id'] ?>"
onclick="return confirm('Lock user?')">Lock</a>

<form action="public_entry.php?url=user-reset" method="POST" style="display:inline;">
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<button>Reset</button>
</form>
</td>

</tr>
<?php endforeach; ?>
</table>

<?php renderPagination($total, 5, $page ?? 1); ?>