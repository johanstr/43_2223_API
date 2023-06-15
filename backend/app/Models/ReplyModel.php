<?php

namespace App\Models;

use App\Database\Database;

class ReplyModel
{
   /**
    * Get all the replies in the database
    *
    * @return array           // Records of replies if successful or empty array
    */
   public static function all(): array
   {
      Database::query(
         'SELECT `replies`.*, `users`.`name` AS `username`
         FROM `replies`
         LEFT JOIN `users` ON `users`.`id` = `replies`.`user_id`
         GROUP BY `replies`.`id`'
      );

      return Database::getAll() ?? [];
   }

   /**
    * Get data for one reply based on given ID
    * GET Request
    *
    * @param integer $id      // ID of wanted reply
    *
    * @return array           // Data of the wanted reply if successful or empty array
    */
   public static function find(int $id): array
   {
      Database::query(
         'SELECT `replies`.*, `users`.`name` AS `username` 
         FROM `replies`
         INNER JOIN `users` ON `users`.`id` = `replies`.`user_id`
         WHERE `replies`.`id` = :id
         GROUP BY `replies`.`id`',
         [':id' => $id]
      );

      return [Database::get()] ?? [];
   }

   /**
    * Create a new reply with data given
    * POST Request
    *
    * @param array $data      // Data for the new reply
    *
    * @return array           // Message and ID of new reply if successful or empty array
    */
   public static function create(array $data): array
   {
      // Format the current date and time for MySQL
      $date_created = date('Y-m-d H:i:s');

      Database::query(
         'INSERT INTO `replies`( `content`, `user_id`, `topic_id`, `created_at`, `updated_at`) VALUES(:content, :user_id, :topic_id, :created_at, :updated_at)',
         [
            ':content' => $data['content'],
            ':user_id' => $data['user_id'],
            ':topic_id' => $data['topic_id'],
            ':created_at' => $date_created,
            ':updated_at' => $date_created
         ]
      );

      return [ 'msg' => 'Reply created successfully', 'id' => Database::lastId() ] ?? [];
   }
}