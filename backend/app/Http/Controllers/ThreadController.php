<?php

namespace App\Http\Controllers;

use App\Models\ThreadModel;

class ThreadController
{
   public function index(): array
   {
      return ThreadModel::all();
   }

   public function show(int $id): array
   {
      return ThreadModel::find($id);
   }

   public function create()
   {

   }

   public function update()
   {

   }

   public function destroy()
   {

   }
}