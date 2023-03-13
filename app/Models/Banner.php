<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
	use SoftDeletes;
	use HasFactory;

	protected $fillable = ['banner_type', 'title', 'link', 'image', 'sort_order','created_at','updated_at','deleted_at'];

	protected $dates = ['updated_at','created_at','deleted_at'];
}
