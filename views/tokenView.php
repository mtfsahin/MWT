<!DOCTYPE html>
<html>
<head>
    <title>mwt token</title>
</head>
<body class="container">
<h1>mwt token</h1>

<form method="post" action="index.php">
    <input type="number" name="userid" placeholder="Enter User ID" required>
    <button type="submit">Generate Token</button>
</form>

<?php if (isset($token) && isset($isValid)): ?>
    <p>Generated Token: <?= htmlspecialchars($token) ?></p>
    <p>Token is valid: <?= $isValid ? 'Yes' : 'No' ?></p>
<?php endif; ?>

<style>
    .container {
        background-color: black;
        color: white;
    }
</style>
</body>
</html>
