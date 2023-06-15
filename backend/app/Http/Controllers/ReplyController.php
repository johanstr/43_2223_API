<?php

namespace App\Http\Controllers;

use App\Models\ReplyModel;

class ReplyController
{
   /**
    * Return all the replies in the database
    * GET Request
    *
    * @return array        // Records of the replies
    */
   public function index(): array
   {
      return ReplyModel::all() ?? [];
   }

   /**
    * Get the record of a reply based on given id
    * GET Request
    *
    * @param integer $id      // ID of the wanted reply
    *
    * @return array           // Data of the wanted reply
    */
   public function show(int $id): array
   {
      return ReplyModel::find($id) ?? [];
   }

   /**
    * Create a new reply with data given
    * POST Request
    *
    * @param array $request      // New data to insert as a reply
    *
    * @return array              // Message and last ID of the reply if successfull or empty array
    */
   public function create(array $request): array
   {
      return ReplyModel::create($request) ?? [];
   }

   /**
    * @todo Future implementation
    * Update an existing reply based on given ID with data given
    * PATCH Request
    *
    * @param integer $id      // ID of the reply to update
    * @param array $request   // Updated data for this reply
    *
    * @return array           // For now empty array
    */
   public function update(int $id, array $request): array
   {
      return [];
   }

   /**
    * @todo Future implementation
    * Delete a reply based on given ID
    * DELETE Request
    *
    * @param integer $id      // ID of reply to delete
    *
    * @return array           // For now empty array
    */
   public function destroy(int $id): array
   {
      return [];
   }
}