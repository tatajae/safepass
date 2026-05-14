<?php
include '../config/session.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import Vault</title>
</head>
<body>

<h1>Import Vault</h1>

<input type="file" id="importFile">
<script>
document
.getElementById("importFile")
.addEventListener("change", function(e){

    const file = e.target.files[0];

    const reader = new FileReader();

    reader.onload = function(event){

        const data = JSON.parse(event.target.result);

        console.log(data);

        alert("Vault imported successfully");
    };

    reader.readAsText(file);
});
</script>

</body>
</html>