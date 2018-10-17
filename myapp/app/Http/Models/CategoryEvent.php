<?php

namespace App\Http\Models;

/**
 * Description of Category this is the model for the categories
 *
 * @author Peter Verhaar
 */
class CategoryEvent extends \Illuminate\Database\Eloquent\Model
{

	public $table = "category_event";
	protected $fillable = ['category_id','event_id'];

}

