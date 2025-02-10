<?php
$input_password = "12345";
$hash = password_hash($input_password, PASSWORD_DEFAULT);

echo "Generated Hash: " . $hash . "\n";

if (password_verify($input_password, $hash)) {
    echo "✅ Hash cocok dengan password!";
} else {
    echo "❌ Hash tidak cocok!";
}
?>
