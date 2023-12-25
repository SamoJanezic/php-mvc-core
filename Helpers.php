<?

namespace samojanezic\phpmvc;

class Helpers
{

    public static function removeSpecialChar($str)
    {
        $result = str_ireplace( array( '\'', '"',',' , ';', '<', '>' ), '', $str);
        return strtolower($result);
    }
    public static function getUniqueName($str, $l) :string
    {
        $clean = self::RemoveSpecialChar($str);
        return $clean . '-' . substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

    public static function uploadImage($name, $path) :string
    {
        $target_dir = $path;
        $target_file = $target_dir . basename($_FILES[$name]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $baseName = basename($target_file, $imageFileType);

        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES[$name]["tmp_name"]);
            if($check === false) {
                return "File is not an image.";
            }
        }

        if ($_FILES[$name]["size"] > 5000000) {
            return "Sorry, your file is too large.";
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        $uniqueName = self::getUniqueName(substr($baseName, 0, 8), 8);
        $fullName = $target_dir . $uniqueName . '.' . $imageFileType;

        move_uploaded_file($_FILES[$name]["tmp_name"], $fullName);

        return $fullName;
    }
}