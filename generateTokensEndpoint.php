<?php
    include 'functions.php';
    $numberOfTokens = isset($_GET['numberOfTokens']) ? intval($_GET['numberOfTokens']) : 0;
    if ($numberOfTokens > 0) {
        $tokens = generateToken($numberOfTokens);
        echo json_encode($tokens);
    } else {
        echo 'Invalid input. Please enter a valid number of tokens.';
    }
?>