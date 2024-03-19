<?php

namespace samojanezic\phpmvc;

class Helpers
{
    public static string $error = '';

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

    public static function fileIsGiven($name) {
        if(basename($_FILES[$name]["name"])) {
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
        if(!$check) {
            // array_push(self::$errors, 'File is not an image!');
            self::$error = 'File is not an image!';
        }
        return true;
    }

    public static function checkExt() {
        $imageType = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $target_file = basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(!in_array($imageFileType, $imageType)) {
            // array_push(self::$errors, 'Sorry, only jpg, jpeg, png, gif and webp supported');
            self::$error = 'Sorry, only jpg, jpeg, png, gif and webp supported';
        }
        return true;
    }

    public static function checkSize() {
        if($_FILES["image"]["size"] > 2500000) {
            // array_push(self::$errors, "Sorry, your file is too large.");
            self::$error = "Sorry, your file is too large.";

        }
        return true;
    }
}