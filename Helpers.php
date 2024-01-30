<?

namespace samojanezic\phpmvc;

class Helpers
{
    public int $fileSize = 5000000;

    public static function removeSpecialChar($str)
    {
        $result = str_ireplace( array( '\'', '"',',' , ';', '<', '>', '.' ), '', $str);
        return strtolower($result);
    }

    public static function getUniqueName($str, $l) :string
    {
        $clean = self::RemoveSpecialChar($str);
        return $clean . '-' . substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

    public static function fileIsGiven() {
        if(basename($_FILES['image']["name"])) {
            return true;
        }
    }

    public static function uploadImage($name, $path) :string
    {
        $target_dir = $path;
        $target_file = $target_dir . basename($_FILES[$name]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $baseName = basename($target_file, $imageFileType);

        if(!is_dir($path)) {
            mkdir($path);
        }

        $uniqueName = self::getUniqueName(substr($baseName, 0, 8), 8);
        $fullName = $target_dir . $uniqueName . '.' . $imageFileType;

        move_uploaded_file($_FILES[$name]["tmp_name"], $fullName);

        return $fullName;
    }

    public static function isImage() {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        return $check;
    }

    public static function checkExt() {
        $imageType = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $target_file = basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        var_dump($imageFileType);
        if (in_array($imageFileType, $imageType)) {
            var_dump('yes');
            die;
        } else {
            var_dump('no');
            die;
        }
    }

    public static function checkSize() {
        if($_FILES["image"]["size"] > 5000000) {
            return "Sorry, your file is too large.";
        }
    }


}