<?php

namespace App\Models;

use App\Database\Database;

class TopicModel
{
   /**
    * Get all the topics from the database
    *
    * @return array     // Records of all the topics or empty array
    */
   public static function all(): array
   {
      Database::query(
         'SELECT `topics`.*, `users`.`name` AS `username`, COUNT(`replies`.`id`) AS `reply_count`
         FROM `topics`
         LEFT JOIN `users` ON `users`.`id` = `topics`.`user_id`
         LEFT JOIN `replies` ON `replies`.`topic_id` = `topics`.`id`
         GROUP BY `topics`.`id`'
      );

      // Return array with threads if successful or empty array
      return Database::getAll() ?: [];
   }

   /**
    * Get the record of a topic with all its replies based on given ID
    *
    * @param int $id    // ID of the topic wanted
    *
    * @return array     // Record of the topic with subarray of all the replies, or empty array
    */
   public static function find($id): array
   {
      $topic = [];

      // First get the topic data
      Database::query(
         'SELECT `topics`.*, `users`.`name` AS `username`, COUNT(`replies`.`id`) AS `reply_count`
         FROM `topics`
         LEFT JOIN `users` ON `users`.`id` = `topics`.`user_id`
         LEFT JOIN `replies` ON `replies`.`topic_id` = `topics`.`id`
         WHERE `topics`.`id` = :id
         GROUP BY `topics`.`id`',
         [':id' => $id]
      );

      $topic = Database::get();

      if( ! empty($topic) ) {
         // Last: Get all the replies belonging to the topic
         Database::query(
            'SELECT `replies`.*, `users`.`name` AS `username`
            FROM `replies`
            LEFT JOIN `users` ON `users`.`id` = `replies`.`user_id`
            WHERE `replies`.`topic_id` = :id
            GROUP BY `replies`.`id`',
            [':id' => $id]
         );
   
         // Insert the replies in the $topic array
         $topic['replies'] = Database::getAll();
      }

      // Return the topic with it's replies if successful or empty array
      return $topic ?: [];
   }

   /**
    * @todo Future implementation
    * Create a new topic with data given
    *
    * @param array $data         // Data for the topic
    *
    * @return array              // For now empty array
    */
   public static function create(array $data): array
   {
      return [];
   }
}