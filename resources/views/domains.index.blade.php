<!DOCTYPE html>
<?php foreach ($domains as $domain) : ?>
    <p> <?= "ID: " . htmlspecialchars($domain['id']); ?><p>
    <p> <?= "Name: " . htmlspecialchars($domain['name']); ?><p>
    <p> <?= "Created_at: " . htmlspecialchars($domain['created_at']); ?><p>
    <p> <?= "Updated_at: " . htmlspecialchars($domain['updated_at']); ?><p>
<?php endforeach; ?>