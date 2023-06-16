<?php

namespace App\Models;

use App\Database\Database;

class ThreadModel
{
   /**
    * Get all the threads from the database and return them as an array of records
    *
    * @return array           // Array of records
    */
   public static function all(): array
   {
      Database::query("
         SELECT `threads`.*, `users`.`name` AS `username`, COUNT(`topics`.`id`) AS `topic_count`
         FROM `threads`
         LEFT JOIN `users` ON `users`.`id` = `threads`.`user_id` 
         LEFT JOIN `topics` ON `topics`.`thread_id` = `threads`.`id`
         GROUP BY `threads`.`id`
      ");

      // Return alle records indien gevuld anders een lege array
      return Database::getAll() ?? [];
   }

   /**
    * Get the data of a certain thread based on given ID
    * Also include all of its topics as a subarray
    *
    * @param integer $id         // ID of the thread
    *
    * @return array              // Record of the found thread with it's topics
    */
   public static function find(int $id): array
   {
      // Eerst de bepaalde thread binnenhalen
      Database::query("
         SELECT `threads`.*, `users`.`name` AS `username`, COUNT(`topics`.`id`) AS `topic_count`
         FROM `threads`
         LEFT JOIN `users` ON `users`.`id` = `threads`.`user_id` 
         LEFT JOIN `topics` ON `topics`.`thread_id` = `threads`.`id`
         WHERE `threads`.`id` = :id
         GROUP BY `threads`.`id`
      ", [ ':id' => $id ]);

      $thread = Database::get();

      // Nu alle bijbehorende topics verzamelen
      Database::query("
         SELECT `topics`.*, `users`.`name` AS `username`, COUNT(`replies`.`id`) AS `reply_count`
         FROM `topics`
         LEFT JOIN `users` ON `users`.`id` = `topics`.`user_id`
         LEFT JOIN `replies` ON `replies`.`topic_id` = `topics`.`id`
         WHERE `topics`.`thread_id` = :id
         GROUP BY `topics`.`id`
      ",[ ':id' => $id ]);

      $topics = Database::getAll();

      // Invoegen van de array met topics in de main array $thread
      $thread['topics'] = $topics;

      // Return $thread indien gevuld anders een lege array
      return $thread ?? [];
   }

   /**
    * Create a new thread with data given
    *
    * @param array $data         // Data for the new thread
    * 
    * @return array              // Message and ID of new thread if succesful or empty array
    */
   public static function create(array $data): array
   {
      // Query to insert new thread and execute it
      Database::query(
         'INSERT INTO `threads`( `title`, `description`, `user_id`, `created_at`, `updated_at`) VALUES(:title, :description, :user_id, :created_at, :updated_at)',
         [
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':user_id' => $data['user_id'],
            ':created_at' => date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s')
         ]
      );

      $lastId = Database::lastId();

      Database::query("
         SELECT `threads`.*, `users`.`name` AS `username`, COUNT(`topics`.`id`) AS `topic_count`
         FROM `threads`
         LEFT JOIN `users` ON `users`.`id` = `threads`.`user_id` 
         LEFT JOIN `topics` ON `topics`.`thread_id` = `threads`.`id`
         WHERE `threads`.`id` = :id
         GROUP BY `threads`.`id`
      ", [':id' => $lastId]);

      $new_thread = Database::get();

      // Return nieuwe record indien succesvol anders een lege array
      return $new_thread ?? [];
   }
}