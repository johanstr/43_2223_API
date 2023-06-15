<?php

namespace App\Http\Controllers;

use App\Models\TopicModel;

class TopicController
{
   /**
    * Get all topics for a certain thread
    * GET Request
    *
    * @return array        // Records of topics
    */
   public function index(): array
   {
      return TopicModel::all() ?? [];
   }

   /**
    * Get the data of certain topic based on given ID
    * GET Request
    *
    * @param integer $id   // ID of the wanted topic
    *
    * @return array        // Record of the wanted topic of empty array
    */
   public function show(int $id): array
   {
      return TopicModel::find($id) ?? [];
   }

   /**
    * @todo Future implementation
    * Create a new topic based on data given
    * POST Request
    *
    * @param array $request      // Data for the new topic
    *
    * @return array              // For now empty array
    */
   public function create(array $request): array
   {
      return [];
   }

   /**
    * @todo Future implementation
    * Update an existing topic with given ID and data given
    * PATCH Request
    *
    * @param integer $id         // ID of the topic to update
    * @param array $request      // Updated data for the topic
    *
    * @return array              // For now emtpy array
    */
   public function update(int $id, array $request): array
   {
      return [];
   }

   /**
    * @todo Future implementation
    * Delete a topic from the database based on given ID
    * DELETE Request
    *
    * @param integer $id      // ID of topic to delete
    *
    * @return array           // For now empty array
    */
   public function destroy(int $id): array
   {
      return [];
   }
}