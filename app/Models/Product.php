<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
	protected $fillable = ["name", "slug", "description", "meta_title", "meta_description", "meta_keywords", "sku", "upc"];
}
