<?php
include "connect_db.php";
$stmt = "
INSERT INTO archived_messages (original_message_id, archived_message, deletion_timestamp)
SELECT id, message, deletion_timestamp
FROM messages
WHERE id = ?;

DELETE FROM messages
WHERE id = ?;"
?>