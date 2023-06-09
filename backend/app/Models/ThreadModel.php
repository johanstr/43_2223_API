<?php

namespace App\Models;

use App\Database\Database;

class ThreadModel
{
   public static function all(): array
   {
      Database::query("
         SELECT `threads`.*, `users`.`name` AS `username`, COUNT(`topics`.`id`) AS `topic_count`
         FROM `threads`
         LEFT JOIN `users` ON `users`.`id` = `threads`.`user_id` 
         LEFT JOIN `topics` ON `topics`.`thread_id` = `threads`.`id`
         GROUP BY `threads`.`id`
      ");

      return Database::getAll();
   }

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
      $thread['topics'] = $topics;

      return $thread;
   }

   public static function create()
   {

   }
}