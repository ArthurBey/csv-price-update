<!-- src/View/uploadForm.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSV Price Update</title>
</head>
<body>
<h1>Upload CSV Files</h1>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <label for="newPricingFile">New Pricing CSV:</label>
    <input type="file" id="newPricingFile" name="newPricingFile" required><br><br>

    <label for="oldPricingFile">Old Pricing CSV:</label>
    <input type="file" id="oldPricingFile" name="oldPricingFile" required><br><br>

    <label for="suffix">Itemcode Suffix:</label>
    <input type="text" id="suffix" name="suffix" required><br><br>

    <input type="submit" value="Upload">
</form>
</body>
</html>
