<h1>Liste des utilisateurs</h1>
<a href="/users/add">Ajouter</a>
<table border="1">
    <tr><th>ID</th><th>Login</th><th>Nom</th><th>Prénom</th><th>Rôle</th></tr>
    <?php foreach($users as $u): ?>
        <tr>
            <td><?= $u->getId() ?></td>
            <td><?= $u->getLogin() ?></td>
            <td><?= $u->getNom() ?></td>
            <td><?= $u->getPrenom() ?></td>
            <td><?= $u->getRole() ?></td>
        </tr>
    <?php endforeach; ?>
</table>