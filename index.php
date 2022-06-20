<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="upload-image.php" method="post"  enctype="multipart/form-data">
            <label className="text-white text-sm">Choose file image : </label>
            <input type="file" name="UrlImage" />
            <button className='bg-green-600 text-white text-sm p-1 rounded-sm' type="submit">Upload file</button>
    </form>
</body>
</html>