<?php

namespace App\Http\Controllers;

use App\Models\ThreadModel;

class ThreadController
{
   /**
    * Get all threads and return the data
    * GET Request
    *
    * @return array     // Array with records of threads
    */
   public function index(): array
   {
      return ThreadModel::all();
   }

   /**
    * Get data for one thread based on id given
    * GET Reguest
    *
    * @param integer $id      // ID of the thread
    *
    * @return array           // Record of the thread
    */
   public function show(int $id): array
   {
      return ThreadModel::find($id);
   }

   /**
    * Create a new thread
    * POST Request
    *
    * @param array $request         // Data for the new thread
    *
    * @return array                 // Message and ID of the new created thread
    */
   public function create(array $request): array
   {
      return ThreadModel::create($request);
   }

   /**
    * @todo Future implementation
    * Update and existing thread
    * PATCH Request
    *
    * @return array                 // Updated data of the thread
    */
   public function update(int $id, array $request_data): array
   {
      return [];
   }

   /**
    * @todo Future implementation
    * Destroy a thread based on given id
    * DELETE Request
    *
    * @param int $id                // ID of the thread
    * 
    * @return array                 // Message of the result (Error or Success)
    */
   public function destroy(int $id): array
   {
      return [];
   }
}