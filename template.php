<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Fribar - <?= $title ?></title>
</head>
<body>
<header>
    <h1>Fribar</h1>
</header>
<table>
    <tr>
        <td><a href="/">Accueil</a></td>
        <td><a href="/bar">Bars</a></td>
        <td><a href="/beer">Bières</a></td>
        <td><a href="/about">À propos</a></td>
    </tr>
</table>
<?= $content ?>
</body>
</html>