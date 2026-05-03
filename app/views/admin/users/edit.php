<h2>Edit User</h2>

<form method="POST" action="public_entry.php?url=user-update">

<input type="hidden" name="id" value="<?= $user['id'] ?>">

<label>Username</label>
<input type="text" name="username" value="<?= $user['username'] ?>">

<br>

<label>Email</label>
<input type="email" name="email" value="<?= $user['email'] ?>">

<br>

<label>Role</label>
<select name="role">
<option value="admin">Admin</option>
<option value="user">User</option>
</select>

<br><br>

<button>Save</button>

</form>