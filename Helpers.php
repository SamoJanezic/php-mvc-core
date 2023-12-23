<?

namespace samojanezic\phpmvc;

class Helpers
{

    public function removeSpecialChar($str)
    {
        $result = str_ireplace( array( '\'', '"',',' , ';', '<', '>' ), '', $str);
        return $result;
    }
    public static function getUniqueName($str, $l) :string
    {
        $clean = self::RemoveSpecialChar($str);
        return $clean . '-' . substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

    public static function uploadImage($path) :string
    {
        $target_dir = $path;
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $baseName = basename($target_file, $imageFileType);

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check === false) {
                echo "File is not an image.";
            }
        }

        if ($_FILES["image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        $uniqueName = self::getUniqueName(substr($baseName, 0, 8), 8);
        $fullName = $target_dir . $uniqueName . '.' . $imageFileType;

        move_uploaded_file($_FILES["image"]["tmp_name"], $fullName);

        return $fullName;
    }
}