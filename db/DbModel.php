<?php

namespace samojanezic\phpmvc\db;

use samojanezic\phpmvc\Model;
use samojanezic\phpmvc\Application;
use PDO;

abstract class DbModel extends Model
{
	abstract public static function tableName(): string;

	abstract public function attributes(): array;

	abstract public function primaryKey(): string;

	public function save()
	{
		$tableName = $this->tableName();
		$attributes = $this->attributes();
		$params = array_map(fn($attr) => ":$attr", $attributes);
		$statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).")
			VALUES(".implode(',', $params).")");
		foreach ($attributes as $attribute) {
			$statement->bindValue(":$attribute", $this->{$attribute});
		}
		$statement->execute();

		return true;
	}

	public static function prepare($sql)
	{
		return Application::$app->db->pdo->prepare($sql);
	}

	public static function findOne($where)
	{
		$tableName = static::tableName();
		$attributes = array_keys($where);
		$sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
		$statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
		foreach ($where as $key => $item) {
			$statement->bindValue(":$key", $item);
		}

		$statement->execute();
		return $statement->fetchObject(static::class);
	}

	public static function showAll($column, $id)
	{
		$tableName = static::tableName();
		if($column && $id) {
			$statement = self::prepare("SELECT * FROM $tableName WHERE $column='$id'");
		} else {
			$statement = self::prepare("SELECT * FROM $tableName ORDER BY created_on DESC");
		}
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_OBJ);
	}

	public static function showPublisher($userID)
	{
		$statement = self::prepare("SELECT firstname, lastname, user_pic FROM users WHERE id=$userID");
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	public static function deleteRow(int $id)
	{
		$tableName = static::tableName();
		$statement = self::prepare("DELETE FROM $tableName WHERE id = $id");
		$statement->execute();
	}

	public static function editRow($id, $title, $content, $image){
		$tableName = static::tableName();
		$statement = self::prepare("UPDATE $tableName
									SET title = '$title', content = '$content', image = '$image'
									WHERE id = $id");
		$statement->execute();
	}
}