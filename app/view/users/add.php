<h1>Ajouter un utilisateur</h1>
<form method="post" action="/users/add">
    <input type="hidden" name="_csrf" value="<?= $csrf ?>">
    <input type="text" name="login" placeholder="Login" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <input type="text" name="nom" placeholder="Nom"><br>
    <input type="text" name="prenom" placeholder="Prénom"><br>
    <select name="role">
        <option value="user">User</option>
        <option value="secretaire">Secrétaire</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Ajouter</button>
</form>