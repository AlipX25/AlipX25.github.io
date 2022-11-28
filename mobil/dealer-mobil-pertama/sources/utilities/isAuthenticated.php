<?php
if (isset($_SESSION['id'])) {
    header("Location: $sourcePath/../index.php");
};
