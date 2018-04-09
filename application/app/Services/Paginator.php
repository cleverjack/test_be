<?php namespace App\Services;

use Cache;
use Eloquent;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginator {

   private $defaultPerPage = 10;

   //columns that should be searched for a specific resource
   private $usersSearchColumns = ['email', 'first_name', 'last_name'];
   private $tracksSearchColumns = ['name', 'album_name', 'artists'];
   private $artistsSearchColumns = ['name'];
   private $albumsSearchColumns = ['name'];
   private $genresSearchColumns = ['name'];
   private $playlistsSearchColumns = ['name'];

   /**
    * Paginate given model.
    *
    * @param Eloquent $model
    * @param array $input
    * @param null|string $table
    *
    * @return LengthAwarePaginator
    */
   public function paginate($model, $input, $table = null)
   {
      $table = $table ? $table : $model->table;
      if ( ! isset($input['itemsPerPage'])) $input['itemsPerPage'] = $this->defaultPerPage;
      if ( ! isset($input['page'])) $input['page'] = 1;

      // $count = Cache::remember($table.'count', Carbon::now()->addDays(1), function() use($model) {
      //    return $model->count();
      // });

    //   dd($model); exit;
      
      if (isset($input['query'])) {
         $model = $this->applySearchQuery($model, $input['query'], $table);
      }

      if ($input['order_column'] != "") {
            $model = $model->orderBy($input['order_column'], $input['order_type']);
      }

      $offset = ($input['page'] - 1) * $input['itemsPerPage'];

      $count = $model->count();


    //   return $input;
      return new LengthAwarePaginator(
          $model->limit($input['itemsPerPage'])->offset($offset)->get(),
          $count,
          $input['itemsPerPage'],
          $input['page']
      );
   }

   /**
    * Apply search constraint to given model.
    *
    * @param Eloquent $model
    * @param string $q
    * @param string $table
    *
    * @return Eloquent
    */
   private function applySearchQuery($model, $q, $table)
   {
      $columns = $this->{$table.'SearchColumns'};
      $q       = $q = '%'.$q.'%';

      foreach($columns as $key => $column) {
         if ($key === 0) {
            $model = $model->where($column, 'like', $q);
         } else {
            $model = $model->orWhere($column, 'like', $q);
         }
      }

      return $model;
   }

   private function applyOrderFilter($model, $name, $type, $table)
   {
       
       echo $name.'Hello'.$type;
       exit;
   }
}
