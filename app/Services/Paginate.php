<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class Paginate
{
    private $db;
    private $with = false;
    private $where = false;
    private $withTrashed = false;
    private $onlyTrashed = false;
    private $orderBy = false;
    private $orderType = 'ASC';
    private $orderById = false;
    private $conditions = [];
    private $relations = [];


    public function __construct( private Model $model, private string $table, private  $page)
    {
        $this->db = DB::table($this->table);
        $model::query();
    }



    public function withTrashed(): self
    {
        $this->withTrashed = true;
        return $this;
    }

    public function onlyTrashed(): self
    {
        $this->onlyTrashed = true;
        return $this;
    }

    public function where(array $conditions): self
    {
        $this->where = true;
        $this->conditions = $conditions;
        return $this;
    }

    public function with(array $relations): self
    {
        $this->with = true;
        $this->relations = $relations;
        return $this;
    }

    public function orderBy($orderBy, $type = 'ASC'): self
    {
        if ($orderBy = 'id')
            $this->orderById = true;
        else $this->orderBy = $orderBy;

        $this->orderType = $type;
        return $this;
    }

    public function get(array $columns = ['*']): array
    {
        $page = ($this->page <= 1  || $this->page == null) ? 0 : $this->page - 1;
        $pages = $this->pages();
        $success['totalPage'] = $pages != 0 ? $pages : 1;
        $success['lastPage'] = $pages != 0 ? $pages : 1;
        $success['current_page'] = $page + 1;
        $success['data'] = $this->data($page, $columns);
        return $success;
    }

    private function data(int $page, array $columns = ['*']): Collection
    {
        return $this->model::when($this->onlyTrashed, function ($q) {
            $q->onlyTrashed();
        })
            ################ withTrashed  ################
            ->when($this->withTrashed, function ($q) {
                $q->withTrashed();
            })
            ################ where  ################
            ->when($this->where, function ($q) {
                $q->where($this->conditions);
            })
            ##################  with relations ###################
            ->when($this->with, function ($q) {
                $q->with($this->relations);
            })
            ##################  order by expect id ###################
            ->when($this->orderBy, function ($q) {
                $q->orderBy($this->orderBy, $this->orderType)
                    ->orderBy('id', $this->orderType);
            })
            ##################  order by id ###################
            ->when($this->orderById, function ($q) {
                $q->orderBy('id', $this->orderType);
            })
            ##################  get result ###################
            ->skip($page * 10)->take(10)->get($columns);
    }

    private function pages(): int
    {
        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this->model))) {
            if (!$this->withTrashed) {
                $this->db->where('deleted_at', null);
            }
            elseif ($this->onlyTrashed) {
                $this->db->where('deleted_at', '!=', null);
            }
        }
        if ($this->where) {
            $this->db->where($this->conditions);
        }

        $pages = ceil($this->db->count() / 10);
        return $pages;
    }
}
